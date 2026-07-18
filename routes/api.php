<?php

use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\ZoneServeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AD SERVING
|--------------------------------------------------------------------------
*/

Route::get('/zones/{token}/serve', [
    ZoneServeController::class,
    'serve',
])->name('api.zones.serve');

/*
|--------------------------------------------------------------------------
| TRACKING
|--------------------------------------------------------------------------
*/

Route::prefix('track')
    ->middleware('throttle:tracking')
    ->group(function () {
        Route::post('/impression', [
            TrackingController::class,
            'impression',
        ])->name('api.track.impression');

        Route::post('/click', [
            TrackingController::class,
            'click',
        ])->name('api.track.click');
    });