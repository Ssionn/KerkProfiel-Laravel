<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptInviteRequest;
use App\Http\Requests\InviteRequest;
use App\Mail\InviteUser;
use App\Models\Invitation;
use App\Models\Role;
use App\Repositories\InvitationRepository;
use App\Repositories\RolesRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository,
        protected InvitationRepository $invitationRepository,
        protected RolesRepository $rolesRepository
    ) {}

    public function sendInvite(InviteRequest $request): RedirectResponse
    {
        $existingInvitation = $this->invitationRepository->findInvitationByEmail($request->invite_email);

        if ($existingInvitation) {
            return redirect()->back()->with('toast', [
                'message' => 'Deze gebruiker heeft al een uitnodiging voor dit team',
                'type' => 'error',
            ]);
        }

        $team = Auth::user()->team;

        $invitation = $this->invitationRepository->createInvitation(
            $request->invite_email,
            bin2hex(random_bytes(24)),
            $team->id
        );

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
        $invitation = $this->invitationRepository->findInvitationByNullableToken($token);

        if (! $invitation) {
            return redirect()->route('teams')->with('toast', [
                'message' => 'Deze uitnodiging bestaat niet',
                'type' => 'error',
            ]);
        }

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
        $invitation = $this->invitationRepository->findInvitationByNullableToken($token);
        $memberRole = $this->rolesRepository->findMemberRole();

        if ($invitation->accepted_at) {
            return redirect()->route('teams.accept', ['token' => $token])
                ->with('toast', [
                    'message' => 'Deze uitnodiging is niet meer geldig',
                    'type' => 'error',
                ]);
        }

        $user = $this->userRepository->createUser(
            $request->username,
            $request->email,
            $request->password,
        );

        $user->associateTeamToUserByTeamId($invitation->team_id);
        $user->associateRoleToUser($memberRole->name);

        $invitation->update(['accepted_at' => now()]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('toast', [
                'message' => "Je bent toegevoegd aan {Auth::user()->team->name}",
                'type' => 'success'
            ]);
    }
}
