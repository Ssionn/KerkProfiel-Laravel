<?php

namespace App\Http\Controllers;

use App\Repositories\SurveysRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected SurveysRepository $surveysRepository
    ) {}

    public function index(): View
    {
        $surveys = $this->surveysRepository->getTeamSurveys();

        return view('dashboard', [
            'surveys' => $surveys,
        ]);
    }
}
