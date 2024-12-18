<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TeamsRepository
{
    public function createTeam(string $name, string $description): Team
    {
        $team = new Team([
            'name' => $name,
            'description' => $description,
            'user_id' => Auth::user()->id,
        ]);

        $team->save();

        return $team;
    }

    public function searchTeams(string $search): Collection
    {
        $team = Team::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->get();

        return $team;
    }
}
