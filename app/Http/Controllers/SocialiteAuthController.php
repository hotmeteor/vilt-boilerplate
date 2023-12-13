<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewSocialiteUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as OauthUser;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuthController extends Controller
{
    public function redirect(Request $request, string $driver)
    {
        $request->session()->put('auth_redirect', $request->input('redirect'));

        $socialite = Socialite::driver($driver);

        if ($scopes = config("services.{$driver}.scopes")) {
            $socialite->setScopes($scopes);
        }

        return $socialite->redirect();
    }

    public function callback(Request $request, string $driver)
    {
        $oauthUser = Socialite::driver($driver)->user();

        if (! $user = $this->findUser($driver, $oauthUser)) {
            $action = app(CreateNewSocialiteUser::class);

            $user = $action->create(
                $this->getUserAttributes($driver, $oauthUser)
            );
        }

        Auth::login($user);

        $user->socialAccounts()->updateOrCreate(
            [
                'provider' => $driver,
                'provider_id' => $oauthUser->getId(),
                'team_id' => $user->currentTeam->id,
            ],
            [
                'token' => $oauthUser->token,
                'refresh_token' => $oauthUser->refreshToken,
                'expires_in' => $oauthUser->expiresIn,
            ]
        );

        return redirect()->route('dashboard');
    }

    /**
     * @param  string  $provider
     * @param  OauthUser  $oauthUser
     * @return Model|User|null
     */
    protected function findUser(string $provider, OauthUser $oauthUser): Model|User|null
    {
        return User::query()
            ->where(function ($query) use ($provider, $oauthUser) {
                $query->whereHas(
                    'socialAccounts',
                    fn ($query) => $query
                        ->where('provider', $provider)
                        ->where('provider_id', $oauthUser->getId())
                );

                $query->orWhere('email', strtolower(trim($oauthUser->getEmail())));
            })
            ->first();
    }

    /**
     * @param  string  $provider
     * @param  OauthUser  $oauthUser
     * @return array
     */
    protected function getUserAttributes(string $provider, OauthUser $oauthUser): array
    {
        $names = explode(' ', $oauthUser->getName());

        if ($provider === 'google') {
            return [
                'first_name' => $oauthUser->user['given_name'] ?? head($names) ?? '',
                'last_name' => $oauthUser->user['family_name'] ?? end($names) ?? '',
                'email' => $oauthUser->getEmail(),
            ];
        }

        return [
            'first_name' => head($names) ?? '',
            'last_name' => end($names) ?? '',
            'email' => $oauthUser->getEmail(),
        ];
    }
}
