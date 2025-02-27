<?php

namespace App\Charts;

abstract class BaseChart
{
    abstract public function getData(): array;

    protected function getRandomColor($opacity = 1): string
    {
        return 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ',' . $opacity . ')';
    }

    protected function getConsistentColor(string $key, float $opacity = 1): string
    {
        $hash = bcrypt($key);
        $r = hexdec(substr($hash, 0, 2));
        $g = hexdec(substr($hash, 2, 2));
        $b = hexdec(substr($hash, 4, 2));

        return "rgba($r, $g, $b, $opacity)";
    }
}
