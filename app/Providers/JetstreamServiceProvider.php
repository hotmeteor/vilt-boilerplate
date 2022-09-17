<?php

namespace App\Providers;

use App\Actions\Jetstream\AddAccountMember;
use App\Actions\Jetstream\CreateAccount;
use App\Actions\Jetstream\DeleteAccount;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteAccountMember;
use App\Actions\Jetstream\RemoveAccountMember;
use App\Actions\Jetstream\UpdateAccountName;
use App\Models\Account;
use App\Models\AccountInvitation;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::useTeamModel(Account::class);
        Jetstream::useTeamInvitationModel(AccountInvitation::class);

        Jetstream::createTeamsUsing(CreateAccount::class);
        Jetstream::updateTeamNamesUsing(UpdateAccountName::class);
        Jetstream::addTeamMembersUsing(AddAccountMember::class);
        Jetstream::inviteTeamMembersUsing(InviteAccountMember::class);
        Jetstream::removeTeamMembersUsing(RemoveAccountMember::class);
        Jetstream::deleteTeamsUsing(DeleteAccount::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Administrator users can perform any action.');

        Jetstream::role('editor', 'Editor', [
            'read',
            'create',
            'update',
        ])->description('Editor users have the ability to read, create, and update.');
    }
}
