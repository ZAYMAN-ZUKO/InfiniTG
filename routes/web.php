<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;

// Home
Route::view('/', 'index')->name('home');

// Dashboard
Route::get('/dashboard',[DashboardController::class,'index'])
    ->middleware('auth')
    ->name('dashboard');

// Files
Route::get('/files', [FileController::class, 'index'])
    ->middleware('auth')
    ->name('files');

// Upload
Route::post('/upload', [FileController::class, 'upload'])
    ->middleware('auth')
    ->name('upload');

// Download
Route::get('/download/{id}', [FileController::class, 'download'])
    ->middleware('auth')
    ->name('download');

// Delete (Soft Delete)
Route::delete('/delete/{id}', [FileController::class, 'destroy'])
    ->middleware('auth')
    ->name('delete');


// Restore
Route::put('/restore/{id}', [FileController::class, 'restore'])
    ->middleware('auth')
    ->name('restore');

// Delete Forever
Route::delete('/force-delete/{id}', [FileController::class, 'forceDelete'])
    ->middleware('auth')
    ->name('forceDelete');

// Toggle Favorite
Route::put('/favorite/{id}', [FileController::class, 'toggleFavorite'])
    ->middleware('auth')
    ->name('favorite.toggle');


// Gallery
Route::get('/gallery', [FileController::class, 'gallery'])
    ->middleware('auth')
    ->name('gallery');

// Favorites
Route::get('/favorites', [FileController::class, 'favorites'])
    ->middleware('auth')
    ->name('favorites');

// Recent
Route::get('/recent', [FileController::class, 'recent'])
    ->middleware('auth')
    ->name('recent');
// Trash
Route::get('/trash', [FileController::class, 'trash'])
    ->middleware('auth')
    ->name('trash');



// Settings
Route::get('/settings', [SettingsController::class, 'index'])
    ->middleware('auth')
    ->name('settings');

// Search
Route::get('/search', [FileController::class, 'search'])
    ->middleware('auth')
    ->name('search');

// Rename File
Route::put('/rename/{id}', [FileController::class, 'rename'])
    ->middleware('auth')
    ->name('rename');

// Breeze Authentication Routes
require __DIR__.'/auth.php';