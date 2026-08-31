<?php

namespace App\Services\Telegram;

use danog\MadelineProto\API;
use danog\MadelineProto\Logger as MadelineProtoLogger;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\Logger;

class TelegramClient
{
    protected ?API $api = null;

    protected string $sessionPath;

    public function __construct(string $sessionFile)
    {
        $this->sessionPath = config('storage.telegram.session_path')
            . DIRECTORY_SEPARATOR
            . $sessionFile;

        $directory = dirname($this->sessionPath);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Lazily create and return the MadelineProto API instance.
     */
    protected function initialize(): API
    {
        if ($this->api instanceof API) {
            return $this->api;
        }

        $settings = new Settings();

        $settings->getAppInfo()
            ->setApiId((int) config('storage.telegram.api_id'))
            ->setApiHash((string) config('storage.telegram.api_hash'))
            ->setShowPrompt(false);

        $logger = new Logger();
        $logger->setType(MadelineProtoLogger::FILE_LOGGER);
        $logger->setExtra(storage_path('logs/madelineproto.log'));
        $logger->setLevel(MadelineProtoLogger::LEVEL_WARNING);
        $settings->setLogger($logger);

        // Keep transport settings close to MadelineProto defaults. The previous
        // forced HTTP/DoH transport was causing long waits/cancellations during
        // the multi-request phone login flow on Railway.
        $settings->getConnection()
            ->setTimeout(30.0)
            ->setIpv6(false);

        $this->api = new API(
            $this->sessionPath,
            $settings
        );

        return $this->api;
    }

    public function getApi(): API
    {
        return $this->initialize();
    }

    public function getSessionPath(): string
    {
        return $this->sessionPath;
    }

    public function start(): void
    {
        $this->initialize()->start();
    }

    /**
     * Force MadelineProto to persist the current auth state to the session.
     */
    public function serialize(): void
    {
        $this->initialize()->serialize();
    }

    public function logout(): void
    {
        $this->initialize()->logout();
    }

    public function isAuthorized(): bool
    {
        return $this->initialize()->getAuthorization()
            !== API::NOT_LOGGED_IN;
    }
}
