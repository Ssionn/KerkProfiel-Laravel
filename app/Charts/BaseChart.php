<?php

namespace App\Charts;

use Illuminate\Support\Collection;

abstract class BaseChart
{
    abstract public function getChartData(): Collection;
}
