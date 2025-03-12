<?php

namespace App\Repositories;

class ChartDataRepository
{
    public function getQuantityData(): array
    {
        $data = [
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
                'byRole' => [
                    'Apostel' => 0,
                    'Profeet' => 0,
                    'Leraar' => 0,
                    'Evangelist' => 0,
                    'Herder' => 0,
                ]
            ]
        ];

        foreach ($data['values'] as $person => $values) {
            foreach($values as $index => $score) {
                $role = $data['roles'][$index];
                $data['totals']['byRole'][$role] += $score;
            }
        }

        return $data;
    }
}
