<?php

use App\Http\Controllers\ChannelAuthController;
use App\Http\Controllers\ChannelsController;

Route::prefix('settings/channels')->name('channels.')->group(function () {
    Route::get('/', [ChannelsController::class, 'index'])->name('index');
    Route::delete('/{channel}', [ChannelsController::class, 'destroy'])->name('destroy');

    // Auth
    Route::get('/{service}/redirect', [ChannelAuthController::class, 'redirect'])->name('channel.redirect');
    Route::get('/{service}/callback', [ChannelAuthController::class, 'callback'])->name('channel.callback');
});
