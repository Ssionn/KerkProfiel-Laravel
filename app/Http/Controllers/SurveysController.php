<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSurveyRequest;
use App\Imports\QuestionsImport;
use App\Models\Survey;
use App\Repositories\SurveysRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SurveysController extends Controller
{
    public function __construct(
        protected SurveysRepository $surveysRepository
    ) {
    }

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

    public function showSurvey(Survey $survey, Request $request)
    {
        $survey->load(['questions' => function ($query) {
            $query->orderBy('sequence', 'asc');
        }, 'questions.answers']);

        $currentPage = $request->query('page', 1);
        $question = $survey->questions->get($currentPage - 1);

        if (! $question) {
            if ($currentPage > 1) {
                return redirect()->route('surveys.show', [
                    'survey' => $survey,
                    'page' => $survey->questions->count()
                ]);
            }

            return redirect()->back()->with('toast', [
                'message' => 'Er zijn geen vragen gevonden',
                'type' => 'error',
            ]);
        }

        return view('surveys.show', [
            'survey' => $survey,
            'question' => $question,
            'currentPage' => $currentPage,
            'totalPages' => $survey->questions->count()
        ]);
    }

    // TODO: Implement storing the answer (Check model for the values)
    public function storeAnswer(Survey $survey, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question_id' => 'required',
            'answer' => 'required',
        ]);

        $survey->answers()->firstOrCreate([
            'question_id' => $validated['question_id'],
            'user_id' => Auth::user()->id,
            'answer' => $validated['answer'],
        ]);

        $currentPage = (int) $request->input('page', 1);
        $nextPage = $currentPage + 1;

        if ($nextPage > $survey->questions->count()) {
            return redirect()->route('surveys')->with('toast', [
                'message' => 'Survey is afgerond, het kan even duren voor u de resultaten ziet.',
                'type' => 'success',
            ]);
        }

        return redirect()->route('surveys.show', [
            'survey' => $survey,
            'page' => $nextPage
        ]);
    }
}
