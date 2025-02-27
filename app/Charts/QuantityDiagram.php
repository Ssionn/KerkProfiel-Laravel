<?php

namespace App\Charts;

use App\Charts\BaseChart;
use App\Repositories\ChartDataRepository;

class QuantityDiagram extends BaseChart
{
    public function __construct(
        protected ChartDataRepository $chartDataRepository
    ) {
    }

    public function getData(): array
    {
        $data = $this->chartDataRepository->getData();
        $datasets = [];

        foreach ($data['people'] as $person) {
            $datasets[] = [
                'label' => $person,
                'data' => $data['values'][$person],
                'backgroundColor' => $this->getRandomColor(0.7),
                'borderColor' => $this->getRandomColor(1),
                'borderWidth' => 1,
            ];
        }

        return [
            'chartData' => [
                'labels' => $data['roles'],
                'datasets' => $datasets,
            ],
            'chartOptions' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Role Scores by Person'
                    ]
                ]
            ]
        ];
    }
}
