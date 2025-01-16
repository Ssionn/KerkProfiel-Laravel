<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\TeamCreationRequest;
use App\Models\Survey;
use App\Models\TemporaryImage;
use App\Repositories\SurveysRepository;
use App\Repositories\TeamsRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamsController extends Controller
{
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

        $user = $this->userRepository->findUserById(Auth::user()->id);
        $user->associateTeamToUserByModel($team);
        $user->associateRoleToUser(Roles::TEAMLEADER->value);

        $tempFile = TemporaryImage::where('owner_id', Auth::user()->id)->first();

        if (! $tempFile) {
            return redirect()->route('teams')->with('toast', [
                'message' => 'Team is aangemaakt',
                'type' => 'success',
            ]);
        }

        $filePath = 'avatars/tmp/' . $tempFile->folder . '/' . $tempFile->filename;

        if (! Storage::disk('spaces')->exists($filePath)) {
            return redirect()->route('teams')->with('toast', [
                'message' => 'Er is iets misgegaan met het uploaden van de avatar, maar het team is aangemaakt',
                'type' => 'success',
            ]);
        }

        $fullPath = Storage::disk('spaces')->path($filePath);
        $temporaryUrl = Storage::disk('spaces')->temporaryUrl($filePath, now()->addMinutes(5));

        try {
            $team->addMedia(Storage::disk('spaces')->get($filePath))
                ->usingName($tempFile->filename)
                ->usingFileName($tempFile->filename)
                ->toMediaCollection('avatars', 'spaces');

            Storage::disk('spaces')->deleteDirectory('avatars/tmp/' . $tempFile->folder);
            $tempFile->delete();

            return redirect()->route('teams')->with('toast', [
                'message' => 'Team is aangemaakt',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error uploading team avatar: ' . $e->getMessage());

            return redirect()->route('teams')->with('toast', [
                'message' => 'Er is iets misgegaan met het uploaden van de avatar, maar het team is aangemaakt',
                'type' => 'success',
            ]);
        }
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
