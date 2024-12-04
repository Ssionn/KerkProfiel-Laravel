<?php

namespace App\Repositories;

use App\Enums\SurveyStatus;
use App\Models\Survey;
use Illuminate\Support\Collection;

class SurveysRepository
{
    public function createSurvey(string $name, string $status): Survey
    {
        $survey = new Survey([
            'name' => $name,
            'status' => SurveyStatus::valueOf($status),
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
