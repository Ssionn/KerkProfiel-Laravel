<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptInviteRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\InviteRequest;
use App\Mail\InviteUser;
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
    ) {
    }

    public function sendInvite(InviteRequest $request): RedirectResponse
    {
        $team = Auth::user()->team;

        $invitation = $this->invitationRepository->createInvitation(
            $request->invite_email,
            bin2hex(random_bytes(24)),
            $team->id
        );

        Mail::to($request->invite_email)->queue(
            new InviteUser(
                $team,
                $invitation->invite_email,
                route('teams.accept', $invitation->token)
            )
        );

        return redirect()->back()->with('toast', [
            'message' => 'Uitnodiging succesvol verzonden',
            'type' => 'success',
        ]);
    }

    public function acceptInviteLogin(string $token)
    {
        $invitation = $this->checkInvitationExists($token);

        return view('auth.invitation.login', ['invitation' => $invitation]);
    }

    public function acceptInviteLoginPost(string $token, LoginRequest $loginRequest)
    {
        $invitation = $this->checkInvitationExists($token);
        $memberRole = $this->rolesRepository->findMemberRole();

        $credentials = $loginRequest->validated();

        if (Auth::attempt($credentials)) {
            $loginRequest->session()->regenerate();
            $user = Auth::user();

            if ($user->team_id !== null) {
                $user->guestify();
            }

            $user->associateTeamToUserByTeamId($invitation->team_id);
            $user->associateRoleToUser($memberRole->name);

            $invitation->update(['accepted_at' => now()]);

            return redirect()->route('dashboard')->with('toast', [
                'message' => 'Je bent uitgenodigd om lid te worden van ' . $invitation->team->name,
                'type' => 'success',
            ]);
        }

        return redirect()->route('login')->with('toast', [
            'message' => 'Deze uitnodiging is niet meer geldig',
            'type' => 'error',
        ]);
    }

    public function acceptInvite(string $token)
    {
        $invitation = $this->checkInvitationExists($token);

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role->name === 'teamleader') {
                $invitation->delete();

                return redirect()->route('teams')->with('toast', [
                    'message' => 'Je kunt geen uitnodiging accepteren als je teamleader bent',
                    'type' => 'error',
                ]);
            }

            $user->associateTeamToUserByTeamId($invitation->team_id);
            $user->associateRoleToUser('member');

            $invitation->update(['accepted_at' => now()]);

            $authUserTeam = $user->team;

            return redirect()->route('teams')
                ->with('toast', [
                    'message' => "Je bent toegevoegd aan {$authUserTeam->name}",
                    'type' => 'success',
                ]);
        }

        return view('auth.invitation.accept', ['invitation' => $invitation]);
    }

    public function acceptInvitePost(string $token, AcceptInviteRequest $request)
    {
        $invitation = $this->invitationRepository->findInvitationByNullableToken($token);
        $memberRole = $this->rolesRepository->findMemberRole();

        if ($invitation->accepted_at !== null) {
            $invitation->delete();

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
                'message' => "Je bent toegevoegd aan {$user->team->name}",
                'type' => 'success',
            ]);
    }

    protected function checkInvitationExists(string $token)
    {
        $invitation = $this->invitationRepository->findInvitationByNullToken($token);

        if (!$invitation) {
            $invitation->delete();

            return redirect()->route('login')->with('toast', [
                'message' => 'Deze uitnodiging bestaat niet',
                'type' => 'error',
            ]);
        }

        return $invitation;
    }
}
