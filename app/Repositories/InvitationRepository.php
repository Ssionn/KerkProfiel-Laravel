<?php

namespace App\Repositories;

use App\Models\Invitation;

class InvitationRepository
{
    public function createInvitation(
        string $email,
        string $token,
        string $team_id
    ): Invitation {
        $invitation = new Invitation([
            'email' => $email,
            'token' => $token,
            'team_id' => $team_id,
        ]);

        $invitation->save();

        return $invitation;
    }

    public function findInvitationByEmail(string $email): Invitation|array
    {
        return Invitation::where('email', $email)->first() ?? [];
    }

    public function findInvitationByNullToken(string $token): Invitation
    {
        return Invitation::where('token', $token)
            ->whereNull('accepted_at')
            ->first();
    }
}
