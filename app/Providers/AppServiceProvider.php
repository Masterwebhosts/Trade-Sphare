<?php

namespace App\Providers;

use App\Models\Click;
use App\Observers\ClickObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        // Register model observers
        Click::observe(ClickObserver::class);

        // Tracking rate limiter
        RateLimiter::for('tracking', function (Request $request) {
            return Limit::perMinute(120)
                ->by($request->ip());
        });
    }
}