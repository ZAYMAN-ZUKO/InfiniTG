<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ProfileController;
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
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Files
    |--------------------------------------------------------------------------
    */

    Route::get('/files', [FileController::class, 'index'])
        ->name('files.index');

    Route::post('/upload', [FileController::class, 'upload'])
        ->name('upload');

    Route::get('/download/{id}', [FileController::class, 'download'])
        ->name('download');

    Route::get('/preview/{id}', [FileController::class, 'preview'])
        ->name('preview');

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
    | Folders
    |--------------------------------------------------------------------------
    */

    Route::post('/folders', [FolderController::class, 'store'])
        ->name('folders.store');

    Route::get('/folders/{folder}', [FolderController::class, 'show'])
        ->name('folders.show');

    Route::put('/folders/{folder}', [FolderController::class, 'update'])
        ->name('folders.update');

    Route::delete('/folders/{folder}', [FolderController::class, 'destroy'])
        ->name('folders.destroy');

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('settings');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

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
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
