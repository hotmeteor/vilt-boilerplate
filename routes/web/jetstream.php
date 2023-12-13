<?php

// Override Jetstream Team Invitation route
// https://mariogiancini.com/making-laravel-jetstream-team-invitations-better
use App\Http\Controllers\TeamInvitationsController;
use Laravel\Jetstream\Jetstream;

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {

    $authMiddleware = config('jetstream.guard')
        ? 'auth:'.config('jetstream.guard')
        : 'auth';

    $authSessionMiddleware = config('jetstream.auth_session', false)
        ? config('jetstream.auth_session')
        : null;

    Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware, 'verified']))], function () {
        // Teams...
        if (Jetstream::hasTeamFeatures()) {
            Route::get('/team-invitations/{invitation}', [TeamInvitationsController::class, 'accept'])
                ->middleware(['signed'])
                ->name('team-invitations.accept');
        }
    });
});
