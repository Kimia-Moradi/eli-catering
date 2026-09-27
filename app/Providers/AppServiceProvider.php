<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Only affects production — local development still works over
        // plain http:// without needing a certificate.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
