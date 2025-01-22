<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\TeamCreationRequest;
use App\Models\Survey;
use App\Models\TemporaryImage;
use App\Repositories\SurveysRepository;
use App\Repositories\TeamsRepository;
use App\Repositories\UserRepository;
use App\Services\ImageHolderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamsController extends Controller
{
    public const disk_name = 'spaces';
    public const teamleader = Roles::TEAMLEADER->value;

    public function __construct(
        protected TeamsRepository $teamsRepository,
        protected UserRepository $userRepository,
        protected SurveysRepository $surveysRepository,
    ) {
    }

    public function index(): View|RedirectResponse
    {
        $team = Auth::user()->team;

        if (! $team) {
            return redirect()->route('teams.create');
        }

        $users = $team->users()
            ->when(request('role_type'), function ($query, $roleType) {
                $query->whereHas('role', fn ($query) => $query->where('name', $roleType));
            })
            ->with('role')
            ->paginate(9);

        $surveys = $this->surveysRepository->getAdminSurveys();

        return view('teams.index', [
            'team' => $team,
            'users' => $users,
            'surveys' => $surveys,
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
            $request->team_description,
        );

        Auth::user()->associateTeamToUserByModel($team);
        Auth::user()->associateRoleToUser(self::teamleader);

        $teamAvatar = $this->teamsRepository->getTeamAvatar(
            ImageHolderService::getRecentFolder()
        );

        if (! $teamAvatar) {
            return redirect()->route('teams')->with('toast', [
                'message' => "{$team->name} is gecreëerd, maar er is iets misgegaan met het uploaden van de avatar",
                'type' => 'success',
            ]);
        }

        $path = "avatars/tmp/{$teamAvatar->folder}/{$teamAvatar->filename}";
        $team->addMedia(storage_path('app/public/' . $path))
            ->usingFileName($teamAvatar->filename)
            ->storingConversionsOnDisk(self::disk_name)
            ->toMediaCollection(
                'team_avatars',
                self::disk_name
            );

        Storage::disk('public')->deleteDirectory("avatars/tmp/{$teamAvatar->folder}");
        $this->teamsRepository->deleteTemporaryImage($teamAvatar->folder);

        return redirect()->route('teams')->with('toast', [
            'message' => "{$team->name} is gecreëerd",
            'type' => 'success',
        ]);
    }

    public function destroy(int $userId): RedirectResponse
    {
        $user = $this->userRepository->findUserById($userId);

        if ($user->role->name === self::teamleader) {
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

    public function createSurvey(Request $request): RedirectResponse
    {
        $request->validate([
            'survey_id' => 'required|exists:surveys,id'
        ]);

        $survey = Survey::findOrFail($request->survey_id);

        $this->surveysRepository->copySurveyForTeam(
            $survey,
            Auth::user()->team->id,
            Auth::user()->team->owner->id,
        );

        return redirect()->route('teams')->with('toast', [
            'message' => 'Survey aangemaakt',
            'type' => 'success',
        ]);
    }
}
