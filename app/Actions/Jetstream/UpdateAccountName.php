<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;

class UpdateAccountName implements UpdatesTeamNames
{
    /**
     * Validate and update the given account's name.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @param  array  $input
     * @return void
     */
    public function update($user, $account, array $input)
    {
        Gate::forUser($user)->authorize('update', $account);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateAccountName');

        $account->forceFill([
            'name' => $input['name'],
        ])->save();
    }
}
