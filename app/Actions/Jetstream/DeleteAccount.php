<?php

namespace App\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteAccount implements DeletesTeams
{
    /**
     * Delete the given account.
     *
     * @param  mixed  $account
     * @return void
     */
    public function delete($account)
    {
        $account->purge();
    }
}
