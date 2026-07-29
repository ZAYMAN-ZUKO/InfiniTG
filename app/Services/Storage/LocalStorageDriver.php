<?php

namespace App\Services\Storage;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocalStorageDriver implements StorageInterface
{
    /**
     * Upload file to local storage.
     */
    public function upload(UploadedFile $file): array
    {
        $storedName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs(
            'uploads',
            $storedName,
            'public'
        );

        return [
            'stored_name' => $storedName,
            'file_path' => $path,
            'storage_driver' => 'local',
            'telegram_file_id' => null,
            'telegram_message_id' => null,
        ];
    }

    /**
     * Download file.
     */
    public function download(File $file)
    {
        return Storage::disk('public')->download(
            $file->file_path,
            $file->original_name
        );
    }

    /**
     * Delete file.
     */
    public function delete(File $file): bool
    {
        if (
            $file->file_path &&
            Storage::disk('public')->exists($file->file_path)
        ) {
            Storage::disk('public')->delete($file->file_path);
        }

        return true;
    }
}