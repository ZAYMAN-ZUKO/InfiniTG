<?php

namespace App\Services\Telegram;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings\AppInfo;

class TelegramClient
{
    private API $api;

    public function __construct(string $sessionFile)
    {
        $sessionPath = config('storage.telegram.session_path')
            . DIRECTORY_SEPARATOR
            . $sessionFile;

        $settings = (new AppInfo())
            ->setApiId((int) config('storage.telegram.api_id'))
            ->setApiHash((string) config('storage.telegram.api_hash'))
            ->setShowPrompt(false);

        $this->api = new API($sessionPath, $settings);
    }

    public function getApi(): API
    {
        return $this->api;
    }

    public function isAuthorized(): bool
{
    return $this->api->getAuthorization() !== null;
}
}