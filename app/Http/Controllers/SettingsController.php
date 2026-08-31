<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\TelegramAccount;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalFiles = File::where('user_id', $user->id)->count();

        $favoriteCount = File::where('user_id', $user->id)
            ->where('is_favorite', true)
            ->count();

        $trashCount = File::onlyTrashed()
            ->where('user_id', $user->id)
            ->count();

        $storageBytes = File::where('user_id', $user->id)
            ->sum('file_size');

        $storageUsed = round($storageBytes / 1024 / 1024, 2);

        $telegram = TelegramAccount::where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        // Fallback for sessions that are still fully usable but whose DB record
        // was removed by the old reload-time authorization check.
        $sessionPath = config('storage.telegram.session_path')
            . DIRECTORY_SEPARATOR
            . 'user_' . $user->id . '.madeline';

        $telegramSessionExists = file_exists($sessionPath) || is_dir($sessionPath);

        $telegramConnected = $telegram !== null || $telegramSessionExists;
        $telegramPhone = $telegram?->phone_number;
        $telegramConnectedAt = $telegram?->created_at;

        return view('settings', compact(
            'user',
            'totalFiles',
            'favoriteCount',
            'trashCount',
            'storageUsed',
            'telegramConnected',
            'telegramPhone',
            'telegramConnectedAt'
        ));
    }
}
