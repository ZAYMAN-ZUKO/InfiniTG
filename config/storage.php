<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Storage Driver
    |--------------------------------------------------------------------------
    */

    'driver' => env('STORAGE_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Telegram Configuration
    |--------------------------------------------------------------------------
    */

    'telegram' => [

        'api_id' => env('TELEGRAM_API_ID'),

        'api_hash' => env('TELEGRAM_API_HASH'),

        'session_path' => storage_path('telegram/sessions'),

    ],

];