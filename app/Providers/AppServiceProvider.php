<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;

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
        // Assets build to /site-assets (not /build) — Netlify's drag-drop
        // deploy drops any folder literally named "build".
        Vite::useBuildDirectory('site-assets');
    }
}
