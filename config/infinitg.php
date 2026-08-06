<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Storage Limits
    |--------------------------------------------------------------------------
    */

    'max_storage_mb' => (int) env('INFINITG_MAX_STORAGE_MB', 2048),

    'max_upload_kb' => (int) env('INFINITG_MAX_UPLOAD_KB', 51200),

    'trash_retention_days' => 30,

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    'pagination' => 25,

    /*
    |--------------------------------------------------------------------------
    | Allowed MIME types (prefix match)
    |--------------------------------------------------------------------------
    */

    'allowed_mimes' => [
        'image/',
        'video/',
        'audio/',
        'text/',
        'application/pdf',
        'application/zip',
        'application/x-zip-compressed',
        'application/x-7z-compressed',
        'application/x-rar-compressed',
        'application/x-tar',
        'application/gzip',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.',
        'application/vnd.ms-excel',
        'application/vnd.ms-powerpoint',
        'application/json',
        'application/xml',
        'application/rtf',
    ],

];