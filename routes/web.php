<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdPublicController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


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

Route::get('/dashboard', function () {

    $user = auth()->user();

    if (! $user) {
        return redirect()
            ->route('login');
    }

    return match ($user->role) {

        'admin' => redirect()
            ->route('admin.dashboard'),

        'advertiser' => redirect()
            ->route('advertiser.dashboard'),

        'publisher' => redirect()
            ->route('publisher.dashboard'),

        default => abort(403),

    };

})
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

    Route::get('/ad/{ad}', function ($adId) {

        $ad = \App\Models\Ad::findOrFail($adId);

        return view('ads.show', compact('ad'));

    })
    ->name('ad.show');


    Route::get('/pages/info', function () {
    return view('pages.contact');
})->middleware('auth')->name('pages.info');

});