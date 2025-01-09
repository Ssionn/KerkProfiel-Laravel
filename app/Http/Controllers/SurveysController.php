<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSurveyRequest;
use App\Imports\QuestionsImport;
use App\Models\Survey;
use App\Repositories\SurveysRepository;
use Maatwebsite\Excel\Facades\Excel;

class SurveysController extends Controller
{
    public function __construct(
        protected SurveysRepository $surveysRepository
    ) {}

    public function index()
    {
        $surveys = $this->surveysRepository->getAdminSurveys();

        return view('surveys.create', [
            'surveys' => $surveys,
        ]);
    }

    public function store(CreateSurveyRequest $request)
    {
        $file = $request->file('excel_file');

        $survey = $this->surveysRepository->createSurvey(
            $request->survey_name,
            $request->survey_status,
        );

        Excel::import(new QuestionsImport($survey->id), $file);

        $survey->update([
            'amount_of_questions' => $survey->questions()->count(),
        ]);

        return redirect()->route('surveys')->with('toast', [
            'message' => 'Survey aangemaakt',
            'type' => 'success',
        ]);
    }

    public function showSurvey(Survey $survey)
    {
        $survey->load('questions.answers');

        return view('surveys.show', [
            'survey' => $survey,
        ]);
    }
}
