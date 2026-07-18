<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Advertiser\DashboardController;
use App\Http\Controllers\Advertiser\CampaignController;
use App\Http\Controllers\Advertiser\AdController;
use App\Http\Controllers\Advertiser\StatsController;
use App\Http\Controllers\Advertiser\TopUpController;

Route::middleware(['auth', 'role:advertiser'])
    ->prefix('advertiser')
    ->name('advertiser.')
    ->group(function () {

        /*
        |-------------------------
        | Dashboard
        |-------------------------
        */
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |-------------------------
        | Campaigns
        |-------------------------
        */
        Route::resource('campaigns', CampaignController::class);

        /*
        |-------------------------
        | Ads
        |-------------------------
        */
        Route::resource('ads', AdController::class);

        /*
        |-------------------------
        | Statistics
        |-------------------------
        */
        Route::get('/stats', [StatsController::class, 'index'])
            ->name('stats.index');

        /*
        |-------------------------
        | Wallet / TopUp
        |-------------------------
        */
        Route::get('/wallet/topup', [TopUpController::class, 'create'])
            ->name('topup.create');

        Route::post('/wallet/topup', [TopUpController::class, 'store'])
            ->name('topup.store');

    });