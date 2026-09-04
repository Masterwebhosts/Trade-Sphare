<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

        then: function () {

            /*
            |--------------------------------------------------------------------------
            | API v1 - External Integrations
            |--------------------------------------------------------------------------
            */

            Route::prefix('api/v1')
                ->middleware('api')
                ->group(base_path('routes/api_v1.php'));

            /*
            |--------------------------------------------------------------------------
            | Admin
            |--------------------------------------------------------------------------
            */

            Route::middleware('web')
                ->group(base_path('routes/admin.php'));

            /*
            |--------------------------------------------------------------------------
            | Advertiser
            |--------------------------------------------------------------------------
            */

            Route::middleware('web')
                ->group(base_path('routes/advertiser.php'));

            /*
            |--------------------------------------------------------------------------
            | Publisher
            |--------------------------------------------------------------------------
            */

            Route::middleware('web')
                ->group(base_path('routes/publisher.php'));

            /*
            |--------------------------------------------------------------------------
            | Authentication
            |--------------------------------------------------------------------------
            */

            Route::middleware('web')
                ->group(base_path('routes/auth.php'));

            /*
            |--------------------------------------------------------------------------
            | Tracking
            |--------------------------------------------------------------------------
            */

            Route::middleware('web')
                ->group(base_path('routes/tracking.php'));
        },
    )

    ->withMiddleware(function (Middleware $middleware): void {


       $middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,

    'api.v1.auth' =>
        \App\Http\Middleware\ApiV1Authentication::class,

    'api.v1.integration' =>
        \App\Http\Middleware\ApiV1Integration::class,

    'api.v1.permission' =>
        \App\Http\Middleware\ApiV1Permission::class,
]);
    })

    ->withEvents(discover: [
        app_path('Listeners'),
    ])

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();
