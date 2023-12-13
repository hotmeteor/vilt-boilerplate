<?php

namespace Database\Seeders;

use App\Models\User;

class UserSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data('users') as $data) {
            $user = User::factory()
                ->withPersonalAccount()
                ->create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                ]);

            if (array_key_exists('account', $data)) {
                $user->personalTeam()->update(data_get($data, 'account'));
            }

            if (array_key_exists('other_accounts', $data)) {
                foreach ($data['other_accounts'] as $email) {
                    $owner = User::firstWhere('email', $email);

                    $owner->personalTeam()->users()->attach($user);
                }
            }
        }
    }
}
