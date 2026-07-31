<?php

namespace App\Services\Telegram;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;

class TelegramClient
{
    protected API $api;

    public function __construct(string $sessionFile)
    {
        $sessionPath = config('storage.telegram.session_path')
            . DIRECTORY_SEPARATOR
            . $sessionFile;

        if (! is_dir(dirname($sessionPath))) {
            mkdir(dirname($sessionPath), 0755, true);
        }

        $settings = new Settings();

        $settings->getAppInfo()
            ->setApiId((int) config('storage.telegram.api_id'))
            ->setApiHash((string) config('storage.telegram.api_hash'))
            ->setShowPrompt(false);

        $this->api = new API($sessionPath, $settings);
    }

    public function getApi(): API
    {
        return $this->api;
    }

    public function start(): void
    {
        $this->api->start();
    }

    public function serialize(): void
    {
        $this->api->serialize();
    }

    public function logout(): void
    {
        $this->api->logout();
    }

    public function isAuthorized(): bool
    {
        return $this->api->getAuthorization() !== API::NOT_LOGGED_IN;
    }
}