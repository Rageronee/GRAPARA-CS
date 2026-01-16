<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\URL;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');

            // Force Serverless-Safe Configurations
            config(['session.driver' => 'database']); // Use TiDB for sessions
            config(['session.secure' => true]);     // Secure cookies
            config(['logging.default' => 'stderr']); // Log to Vercel console
            config(['view.compiled' => '/tmp']);    // Writable tmp dir for views
        }
    }
}
