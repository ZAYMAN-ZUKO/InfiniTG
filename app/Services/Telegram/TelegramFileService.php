<?php

namespace App\Services\Telegram;

use danog\MadelineProto\API;
use Illuminate\Http\UploadedFile;

class TelegramFileService
{
    protected ?API $api = null;

    public function __construct(
        protected TelegramClient $client
    ) {
        // Do NOT initialize MadelineProto here.
        // It will be initialized only when api() is actually called.
    }

    /**
     * Get the MadelineProto API instance lazily.
     */
    protected function api(): API
    {
        return $this->api ??= $this->client->getApi();
    }

    /**
     * Upload file to Telegram Saved Messages.
     */
    public function upload(string|UploadedFile $file): array
    {
        try {

            if ($file instanceof UploadedFile) {
                $filePath = $file->getRealPath();
            } else {
                $filePath = $file;
            }

            if (! $filePath || ! file_exists($filePath)) {
                throw new \RuntimeException(
                    'File does not exist.'
                );
            }

            $result = $this->api()->messages->sendMedia(
                peer: 'me',
                media: [
                    '_'    => 'inputMediaUploadedDocument',
                    'file' => $filePath,
                ],
                message: ''
            );

            $message = null;

            foreach ($result['updates'] ?? [] as $update) {

                if (
                    ($update['_'] ?? null)
                    === 'updateNewMessage'
                ) {
                    $message = $update['message'] ?? null;
                    break;
                }
            }

            if (! $message) {
                throw new \RuntimeException(
                    'Telegram message not found.'
                );
            }

            return [

                'success' => true,

                'message' =>
                    'File uploaded successfully.',

                'telegram_message_id' =>
                    $message['id'] ?? null,

                'telegram_chat_id' =>
                    $message['peer_id'] ?? null,

                'telegram_file_id' =>
                    $message['media']['document']['id']
                    ?? null,

            ];

        } catch (\Throwable $e) {

            logger()->error(
                'Telegram upload failed',
                [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ]
            );

            return [

                'success' => false,

                'message' => $e->getMessage(),

            ];
        }
    }

    /**
     * Download file from Telegram.
     */
    public function download(
        int $messageId,
        int $chatId,
        string $destination
    ): bool {

        try {

            $messages = $this->api()
                ->messages
                ->getMessages(
                    id: [
                        [
                            '_'  => 'inputMessageID',
                            'id' => $messageId,
                        ],
                    ]
                );

            $message = $messages['messages'][0] ?? null;

            if (
                ! $message ||
                empty($message['media']) ||
                empty($message['media']['document'])
            ) {
                return false;
            }

            $document = $message['media']['document'];

            $this->api()->downloadToFile(
                $document,
                $destination
            );

            clearstatcache(true, $destination);

            return file_exists($destination)
                && filesize($destination) > 0;

        } catch (\Throwable $e) {

            logger()->error(
                'Telegram download failed',
                [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ]
            );

            return false;
        }
    }

    /**
     * Delete Telegram message.
     */
    public function delete(int $messageId): bool
    {
        try {

            $this->api()
                ->messages
                ->deleteMessages(
                    revoke: true,
                    id: [$messageId]
                );

            return true;

        } catch (\Throwable $e) {

            logger()->error(
                'Telegram delete failed',
                [
                    'message' => $e->getMessage(),
                    'message_id' => $messageId,
                ]
            );

            return false;
        }
    }

    /**
     * Get Telegram message.
     */
    public function getMessage(
        int $messageId
    ): ?array {

        try {

            return $this->api()
                ->messages
                ->getMessages(
                    id: [
                        [
                            '_'  => 'inputMessageID',
                            'id' => $messageId,
                        ],
                    ]
                );

        } catch (\Throwable $e) {

            logger()->error(
                'Telegram get message failed',
                [
                    'message' => $e->getMessage(),
                    'message_id' => $messageId,
                ]
            );

            return null;
        }
    }

    /**
     * Check Telegram authorization.
     */
    public function isAuthorized(): bool
    {
        try {

            return $this->api()
                ->getAuthorization()
                !== API::NOT_LOGGED_IN;

        } catch (\Throwable $e) {

            logger()->error(
                'Telegram authorization check failed',
                [
                    'message' => $e->getMessage(),
                ]
            );

            return false;
        }
    }
}