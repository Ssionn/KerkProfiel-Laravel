<?php

namespace App\Charts;

use App\Repositories\ChartDataRepository;
use Illuminate\Support\Collection;

class TotalScoreDiagram extends BaseChart
{
    public function __construct(
        protected ChartDataRepository $chartDataRepository
    ) {
    }

    public function getChartData(): Collection
    {
        $data = $this->chartDataRepository->getQuantityData();
        $colors = $this->roleColors()->values();

        $dataset = [];
        $dataset[] = [
            'label' => __('dashboard.diagrams.quantity_diagram'),
            'data' => array_values($data['totals']['byRole']),
            'backgroundColor' => $colors->take(count($data['roles']))->toArray(),
            'borderWidth' => 1.4,
        ];

        return collect([
            'chartData' => [
                'labels' => $data['roles'],
                'datasets' => $dataset,
            ],
            'chartOptions' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                    ]
                ],
            ]
        ]);
    }

    protected function roleColors(): Collection
    {
        return collect([
            'rgb(255, 0, 0)',   // Red
            'rgb(0, 0, 255)',   // Blue
            'rgb(60, 179, 113)', // Green
            'rgb(255, 165, 0)', // Yellow
            'rgb(238, 130, 238)' // Pink
        ]);
    }
}
