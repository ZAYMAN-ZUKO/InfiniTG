<?php

namespace App\Providers;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.sidebar', function ($view) {
            $storageUsed = 0;
            $storageMax = config('infinitg.max_storage_mb');
            $storagePercent = 0;

            if (Auth::check()) {
                $bytes = File::where('user_id', Auth::id())->sum('file_size');
                $usedMB = $bytes / 1024 / 1024;
                $storageUsed = round($usedMB, 2);
                $storagePercent = min(round(($usedMB / $storageMax) * 100, 2), 100);
            }

            $view->with(compact('storageUsed', 'storageMax', 'storagePercent'));
        });
    }
}