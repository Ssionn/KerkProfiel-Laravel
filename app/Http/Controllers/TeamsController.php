<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeamsController extends Controller
{
    public function index(): View
    {
        $team = Auth::user()->team;

        return view('teams.index', [
            'team' => $team
        ]);
    }
}
