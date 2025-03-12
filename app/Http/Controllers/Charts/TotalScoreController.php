<?php

namespace App\Http\Controllers\Charts;

use App\Charts\TotalScoreDiagram;
use App\Http\Controllers\Controller;
use IcehouseVentures\LaravelChartjs\Builder;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class TotalScoreController extends Controller
{
    public function __construct(
        protected TotalScoreDiagram $totalScoreDiagram
    ) {
    }

    public function quantityChart(
    ): Builder {
        $data = $this->totalScoreDiagram->getChartData();

        $chart = Chartjs::build()
            ->name('QuantityDiagram')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($data['chartData']['labels'])
            ->datasets($data['chartData']['datasets'])
            ->options($data['chartOptions']);

        return $chart;
    }
}
