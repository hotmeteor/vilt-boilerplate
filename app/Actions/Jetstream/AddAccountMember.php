<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;

class AddAccountMember implements AddsTeamMembers
{
    /**
     * Add a new account member to the given account.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @param  string  $email
     * @param  string|null  $role
     * @return void
     */
    public function add($user, $account, string $email, string $role = null)
    {
        Gate::forUser($user)->authorize('addAccountMember', $account);

        $this->validate($account, $email, $role);

        $newAccountMember = Jetstream::findUserByEmailOrFail($email);

        AddingTeamMember::dispatch($account, $newAccountMember);

        $account->users()->attach(
            $newAccountMember, ['role' => $role]
        );

        TeamMemberAdded::dispatch($account, $newAccountMember);
    }

    /**
     * Validate the add member operation.
     *
     * @param  mixed  $account
     * @param  string  $email
     * @param  string|null  $role
     * @return void
     */
    protected function validate($account, string $email, ?string $role)
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules(), [
            'email.exists' => __('We were unable to find a registered user with this email address.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnAccount($account, $email)
        )->validateWithBag('addAccountMember');
    }

    /**
     * Get the validation rules for adding a account member.
     *
     * @return array
     */
    protected function rules()
    {
        return array_filter([
            'email' => ['required', 'email', 'exists:users'],
            'role' => Jetstream::hasRoles()
                            ? ['required', 'string', new Role]
                            : null,
        ]);
    }

    /**
     * Ensure that the user is not already on the account.
     *
     * @param  mixed  $account
     * @param  string  $email
     * @return \Closure
     */
    protected function ensureUserIsNotAlreadyOnAccount($account, string $email)
    {
        return function ($validator) use ($account, $email) {
            $validator->errors()->addIf(
                $account->hasUserWithEmail($email),
                'email',
                __('This user already belongs to the account.')
            );
        };
    }
}
