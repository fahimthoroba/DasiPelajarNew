<?php

namespace App\Providers;

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
        if (app()->environment('production') || env('FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        // Share Site Settings to all views
        try {
            $pengaturan = \App\Models\PengaturanWeb::first();
            \Illuminate\Support\Facades\View::share('pengaturan', $pengaturan);
        } catch (\Exception $e) {
            // Failsafe if DB not ready
        }
    }
}
