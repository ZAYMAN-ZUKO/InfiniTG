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
            logger()->info('Telegram phone login starting', ['user_id' => Auth::id()]);

            $this->api->phoneLogin($phoneNumber);

            // phoneLogin changes MadelineProto's authorization state to
            // WAITING_CODE. Persist it before this HTTP request ends so the
            // next verify-code request can restore that exact state.
            $this->client->serialize();

            session([
                'telegram_phone' => $phoneNumber,
                'telegram_auth_pending' => true,
            ]);
            session()->save();

            logger()->info('Telegram phone login waiting for code', [
                'user_id' => Auth::id(),
                'authorization' => $this->api->getAuthorization(),
            ]);

            return [
                'success' => true,
                'message' => 'Verification code sent successfully.',
            ];
        } catch (\Throwable $e) {
            logger()->error('Telegram phone login failed', [
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function verifyCode(string $code): array
    {
        try {
            $authorization = $this->api->getAuthorization();

            logger()->info('Telegram code verification starting', [
                'user_id' => Auth::id(),
                'authorization' => $authorization,
                'pending' => (bool) session('telegram_auth_pending', false),
            ]);

            if ($authorization !== API::WAITING_CODE) {
                return [
                    'success' => false,
                    'message' => 'Telegram login session expired. Please send a new code and try again.',
                ];
            }

            $result = $this->api->completePhoneLogin($code);
            $this->client->serialize();

            if (($result['_'] ?? '') === 'account.password') {
                session(['telegram_auth_pending' => true]);
                session()->save();

                return [
                    'success' => false,
                    'requires_password' => true,
                    'message' => 'Two-step verification required.',
                ];
            }

            $self = $this->api->getSelf();

            TelegramAccount::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'phone_number' => $self['phone'] ?? session('telegram_phone'),
                    'session_file' => 'user_' . Auth::id() . '.madeline',
                    'is_active' => true,
                    'last_login_at' => now(),
                ]
            );

            session()->forget(['telegram_phone', 'telegram_auth_pending']);

            return [
                'success' => true,
                'message' => 'Telegram account connected successfully.',
                'user' => $self,
            ];
        } catch (\Throwable $e) {
            logger()->error('Telegram code verification failed', [
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
            ]);

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
            $this->client->serialize();

            $self = $this->api->getSelf();

            TelegramAccount::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'phone_number' => $self['phone'] ?? session('telegram_phone'),
                    'session_file' => 'user_' . Auth::id() . '.madeline',
                    'is_active' => true,
                    'last_login_at' => now(),
                ]
            );

            session()->forget(['telegram_phone', 'telegram_auth_pending']);

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

            session()->forget([
                'telegram_phone',
                'telegram_session',
                'telegram_auth_pending',
            ]);

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
