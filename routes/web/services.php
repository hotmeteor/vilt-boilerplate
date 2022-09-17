<?php

use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\ServicesController;

Route::name('services.')->group(function () {
    Route::post('/components/{component}/services', [ServicesController::class, 'add'])->name('add');
    Route::delete('/components/{component}/services/{service}', [ServicesController::class, 'remove'])->name('remove');
});
