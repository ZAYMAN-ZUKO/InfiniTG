<?php

namespace App\Services\Telegram;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\Logger;
use danog\MadelineProto\Logger as MadelineProtoLogger;

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
            ->setApiId(
                (int) config('storage.telegram.api_id')
            )
            ->setApiHash(
                (string) config('storage.telegram.api_hash')
            )
            ->setShowPrompt(false);

        $logger = new Logger();

        $logger->setType(MadelineProtoLogger::FILE_LOGGER);

        $logger->setExtra(
            storage_path('logs/madelineproto.log')
        );

        $logger->setLevel(
            MadelineProtoLogger::LEVEL_WARNING
        );

        $settings->setLogger($logger);

      $settings->getConnection()
          ->setTimeout(60.0);

       $settings->getConnection()
           ->setUseDoH(true);

        $settings->getConnection()
            ->setIpv6(false);

        $settings->getConnection()
            ->setProtocol(\danog\MadelineProto\Stream\MTProtoTransport\HttpStream::class);

        $this->api = new API(
            $this->sessionPath,
            $settings
        );

        return $this->api;
    }

    /**
     * Get the MadelineProto API instance.
     */
    public function getApi(): API
    {
        return $this->initialize();
    }

    public function getSessionPath(): string
    {
        return $this->sessionPath;
    }

    /**
     * Start MadelineProto.
     */
    public function start(): void
    {
        $this->initialize()->start();
    }

    /**
     * Serialize the session.
     */
    public function serialize(): void
    {
        $this->initialize()->serialize();
    }

    /**
     * Logout from Telegram.
     */
    public function logout(): void
    {
        $this->initialize()->logout();
    }

    /**
     * Check Telegram authorization status.
     */
    public function isAuthorized(): bool
    {
        return $this->initialize()->getAuthorization()
            !== API::NOT_LOGGED_IN;
    }
}
