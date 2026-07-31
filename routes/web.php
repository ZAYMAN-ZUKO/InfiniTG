<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TelegramController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::view('/', 'index')->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Files
    |--------------------------------------------------------------------------
    */

    Route::get('/files', [FileController::class, 'index'])
        ->name('files');

    Route::post('/upload', [FileController::class, 'upload'])
        ->name('upload');

    Route::get('/download/{id}', [FileController::class, 'download'])
        ->name('download');

    Route::delete('/delete/{id}', [FileController::class, 'destroy'])
        ->name('delete');

    Route::put('/restore/{id}', [FileController::class, 'restore'])
        ->name('restore');

    Route::delete('/force-delete/{id}', [FileController::class, 'forceDelete'])
        ->name('forceDelete');

    Route::put('/favorite/{id}', [FileController::class, 'toggleFavorite'])
        ->name('favorite.toggle');

    Route::put('/rename/{id}', [FileController::class, 'rename'])
        ->name('rename');

    /*
    |--------------------------------------------------------------------------
    | Library
    |--------------------------------------------------------------------------
    */

    Route::get('/gallery', [FileController::class, 'gallery'])
        ->name('gallery');
Route::get('/preview/{id}', [FileController::class, 'preview'])
    ->middleware('auth')
    ->name('preview');

    Route::get('/favorites', [FileController::class, 'favorites'])
        ->name('favorites');

    Route::get('/recent', [FileController::class, 'recent'])
        ->name('recent');

    Route::get('/trash', [FileController::class, 'trash'])
        ->name('trash');

    Route::get('/search', [FileController::class, 'search'])
        ->name('search');

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('settings');

    /*
    |--------------------------------------------------------------------------
    | Telegram
    |--------------------------------------------------------------------------
    */

    Route::post('/telegram/send-code', [TelegramController::class, 'sendCode'])
        ->name('telegram.send-code');

    Route::post('/telegram/verify-code', [TelegramController::class, 'verifyCode'])
        ->name('telegram.verify-code');

    Route::post('/telegram/verify-password', [TelegramController::class, 'verifyPassword'])
        ->name('telegram.verify-password');

    Route::post('/telegram/logout', [TelegramController::class, 'logout'])
        ->name('telegram.logout');

    Route::get('/telegram/me', [TelegramController::class, 'me'])
        ->name('telegram.me');

    /*
    |--------------------------------------------------------------------------
    | Development Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/telegram/upload-test', [TelegramController::class, 'uploadTest'])
        ->name('telegram.upload-test');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';