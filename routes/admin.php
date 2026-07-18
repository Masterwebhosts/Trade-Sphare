<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\TopUpApprovalController;
use App\Http\Controllers\Admin\Finance\FinanceDashboardController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Admin\WithdrawalApprovalController;
use App\Http\Controllers\Admin\FraudDashboardController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/finance', [FinanceDashboardController::class, 'index'])
            ->name('finance.dashboard');
            
           Route::get('/fraud', [FraudDashboardController::class, 'index'])
          ->name('fraud.dashboard');

        /*
        |--------------------------------------------------------------------------
        | Finance Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/finance', [FinanceDashboardController::class, 'index'])
            ->name('finance.index');

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */
        Route::resource('users', UserController::class);

        /*
        |--------------------------------------------------------------------------
        | TOPUPS (NEW LEDGER SYSTEM)
        |--------------------------------------------------------------------------
        | يعتمد بالكامل على WalletTransaction + Admin Approval
        */
        Route::prefix('topups')->name('topups.')->group(function () {

            // Pending topups
            Route::get('/', [TopUpApprovalController::class, 'index'])
                ->name('index');

            // Single transaction
            Route::get('/{tx}', [TopUpApprovalController::class, 'show'])
                ->name('show');

            // Approve
            Route::post('/{tx}/approve', [TopUpApprovalController::class, 'approve'])
                ->name('approve');

            // Reject
            Route::post('/{tx}/reject', [TopUpApprovalController::class, 'reject'])
                ->name('reject');
        });

        /*
        |--------------------------------------------------------------------------
        | Campaigns
        |--------------------------------------------------------------------------
        */
        Route::prefix('campaigns')->name('campaigns.')->group(function () {

            Route::get('/', [CampaignController::class, 'index'])->name('index');

            Route::get('/{campaign}', [CampaignController::class, 'show'])->name('show');

            Route::get('/{campaign}/review', [CampaignController::class, 'review'])
                ->name('review');

            Route::post('/{campaign}/approve', [CampaignController::class, 'approve'])
                ->name('approve');

            Route::post('/{campaign}/reject', [CampaignController::class, 'reject'])
                ->name('reject');

            Route::delete('/{campaign}', [CampaignController::class, 'destroy'])
                ->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | Ads Moderation
        |--------------------------------------------------------------------------
        */
        Route::prefix('ads')->name('ads.')->group(function () {

            Route::get('/', [AdController::class, 'index'])->name('index');

            Route::get('/{ad}', [AdController::class, 'show'])->name('show');

            Route::get('/{ad}/moderation', [AdController::class, 'moderation'])
                ->name('moderation');

            Route::post('/{ad}/approve', [AdController::class, 'approve'])
                ->name('approve');

            Route::post('/{ad}/reject', [AdController::class, 'reject'])
                ->name('reject');
        });

        /*
        |--------------------------------------------------------------------------
        | Analytics
        |--------------------------------------------------------------------------
        */
        Route::get('/analytics', [AnalyticsController::class, 'index'])
            ->name('analytics.index');

        /*
        |--------------------------------------------------------------------------
        | Withdrawals
        |--------------------------------------------------------------------------
        */
        Route::prefix('withdrawals')->name('withdrawals.')->group(function () {

            Route::get('/', [WithdrawalController::class, 'index'])
                ->name('index');

            Route::post('/{withdrawal}/approve', [WithdrawalApprovalController::class, 'approve'])
                ->name('approve');

            Route::post('/{withdrawal}/reject', [WithdrawalApprovalController::class, 'reject'])
                ->name('reject');
        });

    });