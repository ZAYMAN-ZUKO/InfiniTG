<?php

namespace App\Services\Storage;

use App\Models\File;
use Illuminate\Http\UploadedFile;

class TelegramStorageDriver implements StorageInterface
{
    public function upload(UploadedFile $file): array
    {
        return [];
    }

    public function download(File $file)
    {
        //
    }

    public function delete(File $file): bool
    {
        return true;
    }
}