<?php

namespace App\Repositories;

use App\Enums\SurveyStatus;
use App\Models\Survey;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SurveysRepository
{
    public function createSurvey(string $name, string $status): Survey
    {
        $survey = new Survey([
            'name' => $name,
            'status' => SurveyStatus::valueOf($status),
            'amount_of_questions' => 0,
            'made_by_admin' => true,
            'team_id' => null,
            'creator_id' => null,
        ]);

        $survey->save();

        return $survey;
    }

    public function copySurveyForTeam(Survey $originalSurvey, int $teamId, int $creatorId): Survey
    {
        $newSurvey = new Survey([
            'name' => $originalSurvey->name,
            'status' => $originalSurvey->status,
            'amount_of_questions' => $originalSurvey->amount_of_questions,
            'made_by_admin' => false,
            'team_id' => $teamId,
            'creator_id' => $creatorId,
        ]);

        $newSurvey->save();

        foreach ($originalSurvey->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->survey_id = $newSurvey->id;
            $newQuestion->save();
        }

        return $newSurvey;
    }

    public function getAdminSurveys(): Collection
    {
        return Survey::where('made_by_admin', true)
            ->where('status', SurveyStatus::PUBLISHED)
            ->get();
    }

    public function getTeamSurveys(): Collection
    {
        return Survey::where('team_id', Auth::user()->team->id)
            ->where('status', SurveyStatus::PUBLISHED)
            ->get();
    }
}
