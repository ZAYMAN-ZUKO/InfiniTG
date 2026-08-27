<?php

namespace App\Services\Telegram;

use App\Models\TelegramAccount;
use danog\MadelineProto\API;
use Illuminate\Support\Facades\Auth;

class TelegramAuthService
{
    protected API $api;

    public function __construct(
        protected TelegramClient $client
    ) {
        $this->api = $client->getApi();
    }

    public function sendCode(string $phoneNumber): array
    {
        try {

            $result = $this->api->phoneLogin($phoneNumber);

            session([
                'telegram_phone' => $phoneNumber,
                'telegram_session' => $result,
            ]);

            return [
                'success' => true,
                'message' => 'Verification code sent successfully.',
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];

        }
    }

    public function verifyCode(string $code): array
    {
        try {

            $result = $this->api->completePhoneLogin($code);

            if (($result['_'] ?? '') === 'account.password') {

                return [
                    'success' => false,
                    'requires_password' => true,
                    'message' => 'Two-step verification required.',
                ];
            }

            $self = $this->api->getSelf();
            

            TelegramAccount::updateOrCreate(
    [
        'user_id' => Auth::id(),
    ],
    [
        'phone_number' => $self['phone'],
        'session_file' => 'user_' . Auth::id() . '.madeline',
        'is_active' => true,
        'last_login_at' => now(),
    ]
);

            return [
                'success' => true,
                'message' => 'Telegram account connected successfully.',
                'user' => $self,
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];

        }
    }

    public function verifyPassword(string $password): array
    {
        try {

            $this->api->complete2falogin($password);

            $self = $this->api->getSelf();

            TelegramAccount::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                ],
                [
                    'phone_number' => $self['phone'] ?? null,
                    'session_file' => 'user_' . Auth::id() . '.madeline',
                    'is_active' => true,
                    'last_login_at' => now(),
                ]
            );

           return [
               'success' => true,
               'message' => 'Telegram account connected successfully.',
               'user' => $self,
           ];

       } catch (\Throwable $e) {

           return [
               'success' => false,
               'message' => $e->getMessage(),
           ];

       }
   }

   public function logout(): array
   {
       try {
           $this->api->logout();

           $sessionPath = $this->client->getSessionPath();

           TelegramAccount::where('user_id', Auth::id())->delete();

           session()->forget(['telegram_phone', 'telegram_session']);

           $this->deleteDirectory($sessionPath);

           return [
               'success' => true,
               'message' => 'Telegram account disconnected successfully.',
           ];
       } catch (\Throwable $e) {
           logger()->error('Telegram disconnect failed', [
               'message' => $e->getMessage(),
               'file' => $e->getFile(),
               'line' => $e->getLine(),
           ]);

           return [
               'success' => false,
               'message' => 'Failed to disconnect: ' . $e->getMessage(),
           ];
       }
   }

   protected function deleteDirectory(string $path): void
   {
       if (! is_dir($path)) {
           return;
       }

       foreach (array_diff(scandir($path), ['.', '..']) as $item) {
           $itemPath = $path . DIRECTORY_SEPARATOR . $item;

           if (is_dir($itemPath)) {
               $this->deleteDirectory($itemPath);
               continue;
           }

           @unlink($itemPath);
       }

       @rmdir($path);
   }

   public function isAuthorized(): bool
    {
        return $this->api->getAuthorization() !== API::NOT_LOGGED_IN;
    }

    public function getMe(): ?array
    {
        try {
            return $this->api->getSelf();
        } catch (\Throwable) {
            return null;
        }
    }
}
