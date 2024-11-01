<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamCreation;
use App\Models\Role;
use App\Models\Team;
use App\Models\TemporaryImage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeamsController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $team = Auth::user()->load(['role.permissions', 'team'])->team;

        if (! $team) {
            return redirect()->route('teams.create');
        }

        $users = Auth::user()->team->users->sortBy(function ($user) {
            return $user->role->name !== 'teamleader';
        });

        return view('teams.index', [
            'team' => $team,
            'users' => $users,
        ]);
    }

    public function create(): View|RedirectResponse
    {
        return view('teams.create');
    }

    public function store(TeamCreation $request): RedirectResponse
    {
        $team = Team::create([
            'name' => $request->team_name,
            'description' => $request->team_description,
            'user_id' => Auth::user()->id,
        ]);

        $user = User::find(Auth::user()->id);
        $user->associate($team);
        $user->role_id = Role::where('name', 'teamleader')->pluck('id')->first();
        $user->save();

        $tempFile = TemporaryImage::where('folder', $request->team_avatar)->first();

        if ($tempFile) {
            $team->addMedia(storage_path('app/public/avatars/tmp/' . $request->folder . '/' . $tempFile->fileName))
                ->toMediaCollection('avatars');

            rmdir(storage_path('app/public/avatars/tmp/' . $request->team_avatar));

            $tempFile->delete();
        }

        return redirect()->route('teams');
    }

    public function destroy(int $userId): RedirectResponse
    {
        $user = User::find($userId);

        $user->role_id = Role::where('name', 'guest')->pluck('id')->first();
        $user->team_id = null;

        $user->save();

        return redirect()->route('teams');
    }
}
