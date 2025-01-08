<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamSettingsController extends Controller
{
    public function index(Team $team): View
    {
        return view('teams.edit', [
            'team' => $team
        ]);
    }
}
