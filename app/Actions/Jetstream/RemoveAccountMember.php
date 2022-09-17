<?php

namespace App\Actions\Jetstream;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Events\TeamMemberRemoved;

class RemoveAccountMember implements RemovesTeamMembers
{
    /**
     * Remove the account member from the given account.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @param  mixed  $accountMember
     * @return void
     */
    public function remove($user, $account, $accountMember)
    {
        $this->authorize($user, $account, $accountMember);

        $this->ensureUserDoesNotOwnAccount($accountMember, $account);

        $account->removeUser($accountMember);

        TeamMemberRemoved::dispatch($account, $accountMember);
    }

    /**
     * Authorize that the user can remove the account member.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @param  mixed  $accountMember
     * @return void
     */
    protected function authorize($user, $account, $accountMember)
    {
        if (! Gate::forUser($user)->check('removeAccountMember', $account) &&
            $user->id !== $accountMember->id) {
            throw new AuthorizationException;
        }
    }

    /**
     * Ensure that the currently authenticated user does not own the account.
     *
     * @param  mixed  $accountMember
     * @param  mixed  $account
     * @return void
     */
    protected function ensureUserDoesNotOwnAccount($accountMember, $account)
    {
        if ($accountMember->id === $account->owner->id) {
            throw ValidationException::withMessages([
                'account' => [__('You may not leave an account that you created.')],
            ])->errorBag('removeAccountMember');
        }
    }
}
