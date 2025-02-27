<?php

namespace App\Repositories;

class ChartDataRepository
{
    public function getData(): array
    {
        return [
            'roles' => ['Apostel', 'Profeet', 'Leraar', 'Evangelist', 'Herder'],
            'people' => ['Willem', 'Gerard', 'Mieke', 'Jannie', 'Silvia'],
            'values' => [
                'Willem' => [35, 70, 15, 0, 15],
                'Gerard' => [65, 30, 20, 0, 15],
                'Mieke' => [30, 20, 0, 45, 65],
                'Jannie' => [10, 10, 40, 20, 20],
                'Silvia' => [0, 5, 20, 5, 25],
            ],
            'totals' => [
                'byPerson' => [
                    'Willem' => 135,
                    'Gerard' => 130,
                    'Mieke' => 160,
                    'Jannie' => 100,
                    'Silvia' => 55,
                ],
                'byRole' => [
                    'Apostel' => 140,
                    'Profeet' => 135,
                    'Leraar' => 95,
                    'Evangelist' => 70,
                    'Herder' => 140,
                ]
            ]
        ];
    }
}
