<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class TeamSettingsController extends Controller
{
    public function edit(Team $team): View
    {
        return view('teams.edit', [
            'team' => $team
        ]);
    }

    public function updateTeam(UpdateTeamRequest $request, Team $team)
    {
        $team->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('teams.edit', $team)->with('toast', [
            'message' => "Teamgegevens zijn succesvol bijgewerkt",
            'type' => 'success'
        ]);


    }

    public function deleteTeam(Team $team)
    {
        $allUsersInTeam = $team->users()->get();

        foreach($allUsersInTeam as $user) {
            $user->guestify();
        }

        $team->delete();

        return redirect()->route('teams')->with('toast', [
            'message' => "Team is succesvol verwijderd",
            'type' => 'success'
        ]);
    }
}
