<?php

use App\Http\Controllers\PlaybooksController;

Route::prefix('playbooks')->name('playbooks.')->group(function () {
    Route::get('/', [PlaybooksController::class, 'index'])->name('index');
    Route::post('/playbooks', [PlaybooksController::class, 'store'])->name('store');
    Route::get('/{playbook}/edit', [PlaybooksController::class, 'edit'])->name('edit');
    Route::put('/{playbook}/edit', [PlaybooksController::class, 'update'])->name('update');
    Route::get('/{playbook}/{slug?}', [PlaybooksController::class, 'show'])->name('show');
    Route::delete('/{playbook}/{slug?}', [PlaybooksController::class, 'destroy'])->name('destroy');
});
