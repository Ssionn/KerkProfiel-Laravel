<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamCreation;
use App\Models\Role;
use App\Models\Team;
use App\Models\TemporaryImage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

        $user->associateTeamToUser($team);
        $user->associateRoleToUser('teamleader');

        $tempFile = TemporaryImage::where('folder', $request->team_avatar)->first();

        if ($tempFile) {
            try {
                $filePath = storage_path('app/public/avatars/tmp/' . $request->team_avatar . '/' . $tempFile->filename);

                if (! file_exists($filePath)) {
                    throw new \Exception('Team avatar file not found: ' . $filePath);
                }

                $team->addMedia($filePath)
                    ->toMediaCollection('avatars', 'public');

                Storage::disk('public')->deleteDirectory('avatars/tmp/' . $request->team_avatar);

                $tempFile->delete();
            } catch (\Exception $e) {
                throw new \Exception('Error uploading team avatar: ' . $e->getMessage());
            }
        }

        return redirect()->route('teams');
    }

    public function destroy(int $userId): RedirectResponse
    {
        $user = User::find($userId);

        $user->guestify();

        $user->save();

        return redirect()->route('teams');
    }
}
