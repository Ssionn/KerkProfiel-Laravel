<?php

namespace App\Repositories;

use App\Models\Team;
use App\Models\TemporaryImage;
use Illuminate\Support\Facades\Auth;

class TeamsRepository
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

    public function getTeamAvatar(string $folder): TemporaryImage
    {
        return TemporaryImage::where('folder', $folder)->first();
    }

    public function deleteTemporaryImage(string $folder): void
    {
        TemporaryImage::where('folder', $folder)->delete();
    }
}
