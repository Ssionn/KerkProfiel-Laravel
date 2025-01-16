<?php

namespace App\Http\Controllers;

use App\Repositories\SurveysRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected SurveysRepository $surveysRepository
    ) {
    }

    public function index(): View
    {
        if (Auth::user()->team_id) {
            $surveys = $this->surveysRepository->getTeamSurveys();

            return view('dashboard', [
                'surveys' => $surveys,
            ]);
        }

        return view('dashboard', [
            'surveys' => collect(),
        ]);
    }
}
