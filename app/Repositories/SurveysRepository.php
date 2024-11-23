<?php

namespace App\Repositories;

use App\Enums\SurveyStatus;
use App\Models\Survey;
use Illuminate\Support\Collection;

class SurveysRepository
{
    public function createSurvey(string $name, string $status, bool $is_available_for_team): Survey
    {
        $survey = new Survey([
            'name' => $name,
            'status' => SurveyStatus::from(strtoupper($status)),
            'is_available_for_team' => $is_available_for_team,
            'amount_of_questions' => 0,
            'team_id' => auth()->user()->team_id,
            'creator_id' => auth()->user()->id,
        ]);

        $survey->save();

        return $survey;
    }

    public function getAllSurveys(int $teamId): Collection
    {
        return Survey::where('team_id', $teamId)->get();
    }
}
