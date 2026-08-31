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

        // Treat the persisted TelegramAccount record as the UI source of truth.
        // A transient MadelineProto authorization check on page load can return
        // false even when the saved session still works for upload/download.
        // Do not delete a valid account record merely because a reload-time
        // probe fails.
        $telegram = TelegramAccount::where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        $telegramConnected = $telegram !== null;
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
