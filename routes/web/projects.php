<?php

use App\Http\Controllers\ProjectsController;

Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectsController::class, 'index'])->name('index');
    Route::post('/projects', [ProjectsController::class, 'store'])->name('store');
    Route::get('/{project}/edit', [ProjectsController::class, 'edit'])->name('edit');
    Route::patch('/{project}', [ProjectsController::class, 'update'])->name('update');
    Route::get('/{project}/{slug?}', [ProjectsController::class, 'show'])->name('show');
    Route::delete('/{project}/{slug?}', [ProjectsController::class, 'destroy'])->name('destroy');
});
