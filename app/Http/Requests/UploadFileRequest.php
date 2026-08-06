<?php

namespace App\Http\Requests;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UploadFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:' . config('infinitg.max_upload_kb'),
            ],
            'folder_id' => [
                'nullable',
                'integer',
                Rule::exists('folders', 'id')->where('user_id', Auth::id()),
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $uploaded = $this->file('file');

            if ($uploaded && !$this->mimeAllowed($uploaded->getMimeType())) {
                $validator->errors()->add(
                    'file',
                    'File type is not allowed. Please upload a document, image, video, audio or archive.'
                );
                return;
            }

            $usedBytes = File::where('user_id', Auth::id())->sum('file_size');
            $maxBytes = config('infinitg.max_storage_mb') * 1024 * 1024;

            if ($uploaded && ($usedBytes + $uploaded->getSize()) > $maxBytes) {
                $validator->errors()->add(
                    'file',
                    'Storage quota exceeded. Please free up space or upgrade your plan.'
                );
            }
        });
    }

    protected function mimeAllowed(string $mime): bool
    {
        foreach (config('infinitg.allowed_mimes') as $allowed) {
            if (str_starts_with($mime, $allowed)) {
                return true;
            }
        }

        return false;
    }
}