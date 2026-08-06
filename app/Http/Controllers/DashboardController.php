<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalFiles = File::where('user_id', $userId)->count();

        $storageBytes = File::where('user_id', $userId)
            ->sum('file_size');

        $maxStorage = config('infinitg.max_storage_mb');

        $usedMB = $storageBytes / 1024 / 1024;

        $storageUsed = round($usedMB, 2);

        $storagePercentage = min(
            round(($usedMB / $maxStorage) * 100, 2),
            100
        );

        $trashCount = File::onlyTrashed()
            ->where('user_id', $userId)
            ->count();

        $favoriteCount = File::where('user_id', $userId)
            ->where('is_favorite', true)
            ->count();

        $recentFiles = File::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalFiles',
            'trashCount',
            'favoriteCount',
            'storageUsed',
            'storagePercentage',
            'maxStorage',
            'recentFiles'
        ));
    }
}