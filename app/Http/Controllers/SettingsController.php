<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\TelegramAccount;
use App\Services\Telegram\TelegramAuthService;
use App\Services\Telegram\TelegramClient;
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

        if ($telegram) {
            try {
                $client = new TelegramClient($telegram->session_file ?? 'user_' . $user->id . '.madeline');
                $telegramIsAuthorized = (new TelegramAuthService($client))->isAuthorized();
            } catch (\Throwable) {
                $telegramIsAuthorized = false;
            }

            if (! $telegramIsAuthorized) {
                $telegram->delete();
                $telegram = null;
            }
        }

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
