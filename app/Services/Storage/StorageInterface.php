<?php

namespace App\Services\Storage;

use Illuminate\Http\UploadedFile;
use App\Models\File;

interface StorageInterface
{
    /**
     * Upload a file to the storage provider.
     */
    public function upload(UploadedFile $file): array;

    /**
     * Download a stored file.
     */
    public function download(File $file);

    /**
     * Delete a stored file.
     */
    public function delete(File $file): bool;
}
