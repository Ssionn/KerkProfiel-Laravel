<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptInviteRequest;
use App\Http\Requests\InviteRequest;
use App\Mail\InviteUser;
use App\Models\Invitation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function sendInvite(InviteRequest $request): RedirectResponse
    {
        $existingInvitation = Invitation::where('email', $request->invite_email)->first();

        if ($existingInvitation) {
            return redirect()->back()->with('toast', [
                'message' => 'Deze gebruiker heeft al een uitnodiging voor dit team',
                'type' => 'error',
            ]);
        }

        $team = Auth::user()->team;

        $invitation = Invitation::create([
            'email' => $request->invite_email,
            'token' => bin2hex(random_bytes(24)),
            'team_id' => $team->id,
        ]);

        Mail::to($request->invite_email)->queue(
            new InviteUser(
                $invitation->invite_email,
                $invitation->token,
                $team->name,
                route('teams.accept', $invitation->token)
            )
        );

        return redirect()->back()->with('toast', [
            'message' => 'Uitnodiging succesvol verzonden',
            'type' => 'success',
        ]);
    }

    public function acceptInvite(string $token)
    {
        $invitation = Invitation::where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role->name === 'teamleader') {
                return redirect()->route('teams')->with('toast', [
                    'message' => "Je bent op dit moment een teamleader van een team.\nJe kunt geen uitnodiging accepteren als je teamleader bent.",
                    'type' => 'error',
                ]);
            }

            $user->associateTeamToUserByTeamId($invitation->team_id);
            $user->associateRoleToUser('member');

            $invitation->update(['accepted_at' => now()]);

            return redirect()->route('teams')
                ->with('toast', [
                    'message' => "Je bent toegevoegd aan {$invitation->team->name}",
                    'type' => 'success'
                ]);
        }

        return view('auth.invitation.accept', ['invitation' => $invitation]);
    }

    public function acceptInvitePost(string $token, AcceptInviteRequest $request)
    {
        $invitation = Invitation::where('token', $token)->first();
        $memberRole = Role::where('name', 'member')->first();

        if ($invitation->accepted_at) {
            return redirect()->route('teams.accept', ['token' => $token])
                ->with('toast', [
                    'message' => 'Deze uitnodiging is niet meer geldig',
                    'type' => 'error',
                ]);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'team_id' => $invitation->team_id,
            'role_id' => $memberRole->id,
        ]);

        $invitation->update(['accepted_at' => now()]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('toast', [
                'message' => "Je bent toegevoegd aan {Auth::user()->team->name}",
                'type' => 'success'
            ]);
    }
}
