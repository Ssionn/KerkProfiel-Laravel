<?php

namespace App\View\Components;

use App\Http\Controllers\Charts\TotalScoreController;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TotalScoreDiagram extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected TotalScoreController $totalScoreController
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.totalscore-diagram', [
            'chart' => $this->totalScoreController->quantityChart()
        ]);
    }
}
