<?php

namespace App\Services\Storage;

use App\Models\File;
use App\Services\Telegram\TelegramClient;
use App\Services\Telegram\TelegramFileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TelegramStorageDriver implements StorageInterface
{
    protected TelegramFileService $telegram;

    public function __construct()
    {
        $this->telegram = new TelegramFileService(
            new TelegramClient(
                'user_' . Auth::id() . '.madeline'
            )
        );
    }

public function upload(UploadedFile $file): array
{
    $response = $this->telegram->upload($file);

    if (!($response['success'] ?? false)) {
        throw new \RuntimeException(
            $response['message'] ?? 'Telegram upload failed.'
        );
    }

    return [

        'stored_name' => Str::uuid() . '.' . $file->getClientOriginalExtension(),

        'file_path' => 'telegram://' . Str::uuid(),

        'telegram_file_id' =>
            $response['telegram_file_id'],

        'telegram_message_id' =>
            $response['telegram_message_id'],

        'telegram_chat_id' =>
            $response['telegram_chat_id'],

        'storage_driver' => 'telegram',

    ];
}

    public function download(File $file)
{
    $tempPath = storage_path(
        'app/temp/' . $file->stored_name
    );

    if (!is_dir(dirname($tempPath))) {
        mkdir(dirname($tempPath), 0755, true);
    }

    $success = $this->telegram->download(
        $file->telegram_message_id,
        $file->telegram_chat_id,
        $tempPath
    );

    if (!$success) {
        throw new \RuntimeException(
            'Failed to download file from Telegram.'
        );
    }

    return $tempPath;
}

public function delete(File $file): bool
{
    return $this->telegram->delete(
        $file->telegram_message_id
    );
}
}