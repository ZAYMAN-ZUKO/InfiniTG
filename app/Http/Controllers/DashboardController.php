<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFiles = File::where('user_id', Auth::id())->count();

        $storageBytes = File::where('user_id', Auth::id())
            ->sum('file_size');

        $storageUsed = round($storageBytes / 1024 / 1024, 2) . ' MB';

        $maxStorage = 2048; // 2 GB

        $usedMB = $storageBytes / 1024 / 1024;

        $storagePercentage = min(
            round(($usedMB / $maxStorage) * 100, 2),
            100
        );

        $trashCount = File::onlyTrashed()
            ->where('user_id', Auth::id())
            ->count();

        $favoriteCount = File::where('user_id', Auth::id())
            ->where('is_favorite', true)
            ->count();

        return view('dashboard', compact(
            'totalFiles',
            'trashCount',
            'favoriteCount',
            'storageUsed',
            'storagePercentage'
        ));;
    }
}