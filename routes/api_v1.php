<?php

use App\Http\Controllers\Api\V1\IntegrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Trade Sphare API v1
|--------------------------------------------------------------------------
|
| External integrations only.
| The Blog is an independent system.
| All integrations require manual Admin approval.
|
*/

/*
|--------------------------------------------------------------------------
| Health
|--------------------------------------------------------------------------
*/

Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'api' => 'Trade Sphare API',
        'version' => 'v1',
        'status' => 'operational',
    ]);
})->name('api.v1.health');


/*
|--------------------------------------------------------------------------
| Integration
|--------------------------------------------------------------------------
*/

Route::prefix('integration')
    ->name('api.v1.integration.')
    ->middleware([
        'api.v1.auth',
        'api.v1.integration',
    ])
    ->group(function () {

        Route::get('/status', [
        IntegrationController::class,
       'status',
    ])
    ->middleware('api.v1.permission:integration.status')
    ->name('status');

    });


/*
|--------------------------------------------------------------------------
| Publishers
|--------------------------------------------------------------------------
*/

Route::prefix('publishers')
    ->name('api.v1.publishers.')
    ->middleware([
        'api.v1.auth',
        'api.v1.integration',
    ])
    ->group(function () {
        //
    });


/*
|--------------------------------------------------------------------------
| Ad Zones
|--------------------------------------------------------------------------
*/

Route::prefix('zones')
    ->name('api.v1.zones.')
    ->middleware([
        'api.v1.auth',
        'api.v1.integration',
    ])
    ->group(function () {
        //
    });


/*
|--------------------------------------------------------------------------
| Ad Serving
|--------------------------------------------------------------------------
*/

Route::prefix('ads')
    ->name('api.v1.ads.')
    ->middleware([
        'api.v1.auth',
        'api.v1.integration',
    ])
    ->group(function () {
        //
    });
