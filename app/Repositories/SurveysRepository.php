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
            'status' => SurveyStatus::valueOf($status),
            'is_available_for_team' => $is_available_for_team ?? false,
            'amount_of_questions' => 0,
            'team_id' => null,
            'creator_id' => null,
        ]);

        $survey->save();

        return $survey;
    }

    public function getAllSurveys(): Collection
    {
        return Survey::all();
    }
}
