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

    public function logout(): void
    {
        $this->api->logout();
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