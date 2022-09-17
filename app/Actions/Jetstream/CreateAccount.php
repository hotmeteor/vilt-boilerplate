<?php

namespace App\Actions\Jetstream;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateAccount implements CreatesTeams
{
    /**
     * Validate and create a new account for the given user.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     *
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function create($user, array $input): mixed
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createAccount');

        AddingTeam::dispatch($user);

        $user->switchAccount($account = $user->ownedAccounts()->create([
            'name' => $input['name'],
            'personal_team' => false,
        ]));

        return $account;
    }
}
