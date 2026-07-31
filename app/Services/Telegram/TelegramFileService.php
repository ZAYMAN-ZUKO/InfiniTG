<?php

namespace App\Services\Telegram;

use danog\MadelineProto\API;
use Illuminate\Http\UploadedFile;

class TelegramFileService
{
    protected API $api;

    public function __construct(
        protected TelegramClient $client
    ) {
        $this->api = $client->getApi();
    }

    /**
     * Upload file to Telegram Saved Messages.
     */
    public function upload(string|UploadedFile $file): array
    {
        try {

            $filePath = $file instanceof UploadedFile
                ? $file->getRealPath()
                : $file;

            $result = $this->api->messages->sendMedia(
                peer: 'me',
                media: [
                    '_'    => 'inputMediaUploadedDocument',
                    'file' => $filePath,
                ],
                message: ''
            );

            $message = null;

            foreach ($result['updates'] as $update) {

                if (($update['_'] ?? null) === 'updateNewMessage') {
                    $message = $update['message'];
                    break;
                }

            }

            if (!$message) {
                throw new \RuntimeException(
                    'Telegram message not found.'
                );
            }

            return [

                'success' => true,

                'message' => 'File uploaded successfully.',

                'telegram_message_id' =>
                    $message['id'],

                'telegram_chat_id' =>
                    $message['peer_id'],

                'telegram_file_id' =>
                    $message['media']['document']['id'] ?? null,

            ];

        } catch (\Throwable $e) {

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
    ): bool
    {
        try {

            $messages = $this->api->messages->getMessages(
                id: [
                    [
                        '_'  => 'inputMessageID',
                        'id' => $messageId,
                    ]
                ]
            );

            if (
                empty($messages['messages'][0]) ||
                empty($messages['messages'][0]['media']) ||
                empty($messages['messages'][0]['media']['document'])
            ) {
                return false;
            }

            $document = $messages['messages'][0]['media']['document'];

            $this->api->downloadToFile(
                $document,
                $destination
            );

            clearstatcache();

            return file_exists($destination)
                && filesize($destination) > 0;

        } catch (\Throwable $e) {

            logger()->error('Telegram download failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return false;

        }
    }

    /**
     * Delete Telegram message.
     */
    public function delete(int $messageId): bool
    {
        try {

            $this->api->messages->deleteMessages(
                revoke: true,
                id: [$messageId]
            );

            return true;

        } catch (\Throwable) {

            return false;

        }
    }

    /**
     * Get Telegram message.
     */
    public function getMessage(int $messageId): ?array
    {
        try {

            return $this->api->messages->getMessages(
                id: [
                    [
                        '_'  => 'inputMessageID',
                        'id' => $messageId,
                    ]
                ]
            );

        } catch (\Throwable) {

            return null;

        }
    }

    /**
     * Check authorization.
     */
    public function isAuthorized(): bool
    {
        return $this->api->getAuthorization() !== API::NOT_LOGGED_IN;
    }
}