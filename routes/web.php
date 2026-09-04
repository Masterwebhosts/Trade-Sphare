<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdPreviewController;
use App\Http\Controllers\AdPublicController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Management\ManagementDashboardController;
use App\Http\Controllers\Management\ProductController;
use App\Http\Controllers\Management\SubscriptionController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome');


/*
|--------------------------------------------------------------------------
| PUBLIC AD EMBED
|--------------------------------------------------------------------------
*/

Route::get('/embed/zones/{token}', [
    AdPublicController::class,
    'embed'
])
->name('zones.embed');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', DashboardRedirectController::class)
    ->middleware([
        'auth',
        'verified'
    ])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])
    ->name('profile.edit');


    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])
    ->name('profile.update');


    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])
    ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Preview Ad
    |--------------------------------------------------------------------------
    */

    Route::get('/ad/{ad}', [
        AdPreviewController::class,
        'show'
    ])
    ->name('ad.show');


    Route::view('/pages/info', 'pages.contact')
        ->name('pages.info');

});

Route::middleware(['auth', 'role:admin'])
    ->prefix('management')
    ->name('management.')
    ->group(function () {

        Route::get('/dashboard', [
            ManagementDashboardController::class,
            'index',
        ])->name('dashboard');

        Route::resource('products', ProductController::class)
            ->except(['show']);

        Route::patch('/products/{product}/toggle', [
            ProductController::class,
            'toggle',
        ])->name('products.toggle');

        Route::resource('subscriptions', SubscriptionController::class)
            ->except(['show']);

    });