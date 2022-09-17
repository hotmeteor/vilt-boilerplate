<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Laravel\Jetstream\Rules\Role;

class InviteAccountMember implements InvitesTeamMembers
{
    /**
     * Invite a new account member to the given account.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @param  string  $email
     * @param  string|null  $role
     * @return void
     */
    public function invite($user, $account, string $email, string $role = null)
    {
        Gate::forUser($user)->authorize('addAccountMember', $account);

        $this->validate($account, $email, $role);

        InvitingTeamMember::dispatch($account, $email, $role);

        $invitation = $account->accountInvitations()->create([
            'email' => $email,
            'role' => $role,
        ]);

        Mail::to($email)->send(new TeamInvitation($invitation));
    }

    /**
     * Validate the invite member operation.
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
        ], $this->rules($account), [
            'email.unique' => __('This user has already been invited to the account.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnAccount($account, $email)
        )->validateWithBag('addAccountMember');
    }

    /**
     * Get the validation rules for inviting a account member.
     *
     * @param  mixed  $account
     * @return array
     */
    protected function rules($account)
    {
        return array_filter([
            'email' => ['required', 'email', Rule::unique('account_invitations')->where(function ($query) use ($account) {
                $query->where('account_id', $account->id);
            })],
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
