<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class TeamRepository
{
    public function createTeam(string $name, string $description): Team
    {
        $team = Team::create([
            'name' => $name,
            'description' => $description,
            'owner_id' => Auth::id(),
        ]);

        return $team;
    }
}
