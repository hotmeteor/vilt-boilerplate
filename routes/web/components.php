<?php

use App\Http\Controllers\ComponentsController;

Route::name('components.')->group(function () {
    Route::post('/{project}/components', [ComponentsController::class, 'store'])->name('store');
    Route::put('/components/{component}', [ComponentsController::class, 'update'])->name('update');
    Route::delete('/components/{component}', [ComponentsController::class, 'destroy'])->name('destroy');
});
