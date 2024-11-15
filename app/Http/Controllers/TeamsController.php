<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamCreationRequest;
use App\Models\TemporaryImage;
use App\Repositories\TeamsRepository;
use App\Repositories\UserRepository;
use App\Enums\Roles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamsController extends Controller
{
    public function __construct(
        protected TeamsRepository $teamsRepository,
        protected UserRepository $userRepository
    ) {
    }

    public function index(): View|RedirectResponse
    {
        $team = Auth::user()->load(['role.permissions', 'team'])->team;

        if (! $team) {
            return redirect()->route('teams.create');
        }

        $users = $team->users()
            ->when(request('role_type'), function ($query, $roleType) {
                $query->whereHas('role', fn ($query) => $query->where('name', $roleType));
            })
            ->with('role')
            ->paginate(9);

        return view('teams.index', [
            'team' => $team,
            'users' => $users,
        ]);
    }

    public function create(): View|RedirectResponse
    {
        return view('teams.create');
    }

    public function store(TeamCreationRequest $request): RedirectResponse
    {
        $team = $this->teamsRepository->createTeam(
            $request->team_name,
            $request->team_description
        );

        $user = $this->userRepository->findUserById(Auth::user()->id);

        $user->associateTeamToUserByModel($team);
        $user->associateRoleToUser(Roles::TEAMLEADER->value);

        $tempFile = TemporaryImage::where('folder', $request->team_avatar)->first();

        if ($tempFile) {
            try {
                $filePath = storage_path('app/public/avatars/tmp/' . $request->team_avatar . '/' . $tempFile->filename);

                if (! file_exists($filePath)) {
                    throw new \Exception('Team avatar file not found: ' . $filePath);
                }

                $team->addMedia($filePath)
                     ->toMediaCollection('avatars', 'local');

                Storage::disk('public')->deleteDirectory('avatars/tmp/' . $request->team_avatar);

                $tempFile->delete();
            } catch (\Exception $e) {
                throw new \Exception('Error uploading team avatar: ' . $e->getMessage());
            }
        }

        return redirect()->route('teams')->with('toast', [
            'message' => 'Team is aangemaakt',
            'type' => 'success',
        ]);
    }

    public function destroy(int $userId): RedirectResponse
    {
        $user = $this->userRepository->findUserById($userId);

        if ($user->role->name === Roles::TEAMLEADER->value) {
            return redirect()->route('teams')->with('toast', [
                'message' => 'Je kan geen teamleader verwijderen',
                'type' => 'error',
            ]);
        }

        $user->guestify();

        return redirect()->route('teams')->with('toast', [
            'message' => "{$user->username} verwijderd",
            'type' => 'success',
        ]);
    }

    public function leaveTeam(int $userId): RedirectResponse
    {
        $user = $this->userRepository->findUserById($userId);

        $team = $user->team;

        $user->guestify();

        return redirect()->route('dashboard')->with('toast', [
            'message' => "{$team->name} verlaten",
            'type' => 'success',
        ]);
    }
}
