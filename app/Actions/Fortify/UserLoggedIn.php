<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;

class UserLoggedIn
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle(Request $request, callable $next)
    {
        // If a user registered, and they had a team invitation,
        // do url intended redirect to team invitation route.
        if (session()->has('teamInvitation') && session()->has('url.intended')) {
            return redirect()->intended();
        }

        return $next($request);
    }
}
