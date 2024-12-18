<?php

namespace App\Services;

use Illuminate\Http\RedirectResponse;

class SurveyCreationService
{
    public function checkIfUserIsAdminForSurveyCreation(): RedirectResponse|bool
    {
        $user = auth()->user();

        if (! in_array($user->role->name, ['Admin'])) {
            return redirect()->route('teams')->with('toast', [
                'message' => 'U heeft geen toestemming om een nieuwe enquête aan te maken',
                'type' => 'error',
            ]);
        }

        return true;
    }

    public function checkIfUserIsTeamleaderForSurveyCreation(): RedirectResponse|bool
    {
        $user = auth()->user();

        if (! $user->team) {
            return redirect()->route('teams')->with('toast', [
                'message' => 'U bent niet lid van een team',
                'type' => 'error',
            ]);
        }

        if (! in_array($user->role->name, ['Teamleader'])) {
            return redirect()->route('teams')->with('toast', [
                'message' => 'U bent niet lid van een team',
                'type' => 'error',
            ]);
        }

        return true;
    }
}
