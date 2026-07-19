<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdPreviewController;
use App\Http\Controllers\AdPublicController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\ProfileController;


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