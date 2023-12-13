<?php

namespace App\Http\Controllers;

use App\Models\TeamInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\AddsTeamMembers;

class TeamInvitationsController extends Controller
{
    /**
     * Accept a team invitation.
     *
     * @param  Request  $request
     * @param  TeamInvitation  $invitation
     * @return RedirectResponse
     */
    public function accept(Request $request, TeamInvitation $invitation)
    {
        app(AddsTeamMembers::class)->add(
            $invitation->team->owner,
            $invitation->team,
            $request->user()->email,
            $invitation->role
        );

        $invitedTeam = $invitation->team;

        // Since the user just accepted invite to this team, set that as the current.
        Auth::user()->switchTeam($invitedTeam);

        $invitation->delete();

        if ($request->session()->has('teamInvitation')) {
            $request->session()->forget('teamInvitation');
        }

        return redirect(config('fortify.home'))->banner(
            __('Great! You have accepted the invitation to join :team.', ['team' => $invitation->team->name]),
        );
    }
}
