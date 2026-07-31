<?php

namespace App\Services\Storage;

use InvalidArgumentException;
use App\Models\File;
class StorageManager
{
    protected StorageInterface $driver;

    public function __construct()
    {
        $driver = config('storage.driver', 'local');

        $this->driver = match ($driver) {
            'local' => new LocalStorageDriver(),
            'telegram' => new TelegramStorageDriver(),
            default => throw new InvalidArgumentException(
                "Unsupported storage driver: {$driver}"
            ),
        };
    }

    public function driver(): StorageInterface
    {
        return $this->driver;
    }

    public function download(File $file)
{
    return $this->driver()->download($file);
}
}