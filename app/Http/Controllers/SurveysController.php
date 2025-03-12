<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSurveyRequest;
use App\Imports\QuestionsImport;
use App\Models\Survey;
use App\Repositories\SurveysRepository;
use App\Enums\SurveyStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class SurveysController extends Controller
{
    public function __construct(
        protected SurveysRepository $surveysRepository
    ) {
    }

    public function create(): View
    {
        $surveys = Survey::where(function($query) {
            $query->where('made_by_admin', true)
                  ->orWhere('team_id', Auth::user()->team_id);
        })
        ->latest()
        ->get();

        return view('surveys.create', [
            'surveys' => $surveys,
        ]);
    }

    public function index(): View
    {
        // Get published surveys that are either admin surveys or belong to the user's team
        $surveys = Survey::where(function($query) {
            $query->where('made_by_admin', true)
                  ->orWhere('team_id', Auth::user()->team_id);
        })
        ->where('status', SurveyStatus::PUBLISHED)
        ->latest()
        ->get();

        return view('surveys.index', [
            'surveys' => $surveys,
        ]);
    }

    public function store(CreateSurveyRequest $request): RedirectResponse
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

    public function showSurvey(Survey $survey, Request $request): View|RedirectResponse
    {
        $survey->load(['questions' => function ($query) {
            $query->orderBy('sequence', 'asc');
        }, 'questions.answers']);

        // Get the current page from the request, or find the last answered question
        $currentPage = $request->query('page', null);

        if (!$currentPage) {
            // Find the last answered question for this user
            $lastAnswer = $survey->answers()
                ->where('user_id', Auth::id())
                ->orderBy('question_id', 'desc')
                ->first();

            if ($lastAnswer) {
                // Get the next question's sequence number
                $nextQuestion = $survey->questions()
                    ->where('sequence', '>', $survey->questions()->where('id', $lastAnswer->question_id)->first()->sequence)
                    ->orderBy('sequence', 'asc')
                    ->first();

                // If there's a next question, go to it, otherwise stay on the last answered question
                $currentPage = $nextQuestion
                    ? $survey->questions()->where('sequence', '<=', $nextQuestion->sequence)->count()
                    : $survey->questions()->where('sequence', '<=', $survey->questions()->where('id', $lastAnswer->question_id)->first()->sequence)->count();
            } else {
                // If no answers yet, start from the beginning
                $currentPage = 1;
            }
        }

        $question = $survey->questions->get($currentPage - 1);

        if (!$question) {
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

        // Check if this question was already answered
        $existingAnswer = $survey->answers()
            ->where('user_id', Auth::id())
            ->where('question_id', $question->id)
            ->first();

        return view('surveys.show', [
            'survey' => $survey,
            'question' => $question,
            'currentPage' => $currentPage,
            'totalPages' => $survey->questions->count(),
            'existingAnswer' => $existingAnswer
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

    public function destroy(Survey $survey): RedirectResponse
    {
        // Delete related questions and answers
        $survey->questions()->delete();
        $survey->answers()->delete();
        $survey->delete();

        return back()->with('toast', [
            'message' => 'Vragenlijst verwijderd',
            'type' => 'success',
        ]);
    }
}
