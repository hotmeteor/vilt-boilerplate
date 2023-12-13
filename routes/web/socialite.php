<?php

use App\Http\Controllers\SocialiteAuthController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('{driver}/redirect', [SocialiteAuthController::class, 'redirect'])->name('redirect');
    Route::get('{driver}/callback', [SocialiteAuthController::class, 'callback'])->name('callback');
});
