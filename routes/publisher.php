<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Publisher\DashboardController;
use App\Http\Controllers\Publisher\AdZoneController;
use App\Http\Controllers\Publisher\WalletController;
use App\Http\Controllers\Publisher\EarningsController;
use App\Http\Controllers\Publisher\AnalyticsController;
use App\Http\Controllers\Publisher\ZoneAnalyticsController;
use App\Http\Controllers\Publisher\WithdrawalController;

Route::middleware(['auth', 'role:publisher'])
    ->prefix('publisher')
    ->name('publisher.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        Route::get('/wallet', [WalletController::class, 'index'])
            ->name('wallet.index');


        Route::get('/earnings', [EarningsController::class, 'index'])
            ->name('earnings.index');


        Route::get('/withdrawals', [WithdrawalController::class, 'index'])
            ->name('withdrawals.index');


        Route::post('/withdrawals', [WithdrawalController::class, 'store'])
            ->name('withdrawals.store');


        /*
        |--------------------------------------------------------------------------
        | Zones
        |--------------------------------------------------------------------------
        */

        Route::resource('zones', AdZoneController::class);


        Route::get('/zones/{id}/analytics', [ZoneAnalyticsController::class, 'index'])
            ->name('zones.analytics');


        /*
        |--------------------------------------------------------------------------
        | Analytics Chart API
        |--------------------------------------------------------------------------
        */

        Route::get('/analytics/chart', [AnalyticsController::class, 'chart'])
            ->name('analytics.chart');

    });