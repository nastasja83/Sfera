<?php

use App\User;
use App\Helpers\ChartHelper;
use Illuminate\Support\Collection;

if (!function_exists('getBeginEndDates')) {
    function getBeginEndDates(string $inputDates = null): array
    {
        return ChartHelper::getBeginEndDates($inputDates);
    }
}

if (!function_exists('getColorsForChart')) {
    function getColorsForChart(int $count): array
    {
        return ChartHelper::getColorsForChart($count);
    }
}

if (!function_exists('getBarChart')) {
    function getBarChart($inputDates, string $name, $chartData)
    {
        return ChartHelper::getBarChart($inputDates, $name, $chartData);
    }
}

if (!function_exists('getPieChart')) {
    function getPieChart(string $name, $chartData)
    {
        return ChartHelper::getPieChart($name, $chartData);
    }
}
