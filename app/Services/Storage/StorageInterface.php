<?php

namespace App\Services\Storage;

use App\Models\File;
use Illuminate\Http\UploadedFile;

interface StorageInterface
{
    /**
     * Upload a file.
     */
    public function upload(UploadedFile $file): array;

    /**
     * Download a file.
     *
     * Returns the full temporary file path.
     */
    public function download(File $file);

    /**
     * Delete a file from storage.
     */
    public function delete(File $file): bool;
}