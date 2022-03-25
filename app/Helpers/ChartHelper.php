<?php

namespace App\Helpers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ChartHelper
{
    public const BACKGROUND_COLORS = [
        'rgba(250, 250, 210)',
        'rgba(255, 239, 213)',
        'rgba(255, 228, 181)',
        'rgba(255, 218, 185)',
        'rgba(238, 232, 170)',
        'rgba(240, 230, 140)',
        'rgba(0, 255, 255)',
        'rgba(224, 255, 255)',
        'rgba(175, 238, 238)',
        'rgba(127, 255, 212)',
        'rgba(64, 224, 208)',
        'rgba(72, 209, 204)',
        'rgba(0, 206, 209)',
        'rgba(152, 251, 152)',
        'rgba(144, 238, 144)',
        'rgba(0, 250, 154)',
        'rgba(0, 255, 127)',
        'rgba(255, 192, 203)',
        'rgba(255, 182, 193)',
        'rgba(255, 160, 122)',
        'rgba(221, 160, 221)',
    ];

    public static function getBeginEndDates(string $inputDates = null): array
    {
        $arrDates = explode(' - ', $inputDates);
        $defaultBeginDate = Carbon::now()->subMonth()->startOfDay();
        $defaultEndDate = Carbon::now()->endOfDay();
        $beginDate = !empty($arrDates[0]) ? Carbon::parse($arrDates[0])->startOfDay() : $defaultBeginDate;
        $endDate = !empty($arrDates[1]) ? Carbon::parse($arrDates[1])->endOfDay() : $defaultEndDate;

        $beginEndDates = [$beginDate, $endDate];
        return $beginEndDates;
    }

    public static function getColorsForChart(int $count): array
    {
        $colors = [];
        for ($i = 0; $i < $count; $i++) {
          $colors[] = self::BACKGROUND_COLORS[rand(0, 20)];
        }
          return $colors;
      }

    public static function getBarChart($inputDates, string $name, $chartData)
    {
        $labels = $chartData->keys()->toArray();
        $data = $chartData->values();
        $colors = self::getColorsForChart(2);

        $chart = app()->chartjs
        ->name($name)
        ->type('bar')
        ->size(['width' => 400, 'height' => 150])
        ->labels($labels)
        ->datasets([
            [
                'label' => $name,
                'backgroundColor' => 'rgba(135, 206, 250)',
                'data' => $data
            ],
        ])
        ->optionsRaw([
            'scales' => [
                'yAxes' => [
                    [
                        'ticks' => [
                            'stepSize' => 1,
                            'beginAtZero' => true
                        ],
                    ],
                ],
            ],
            'title' => [
                'display' => true,
                'text' => $name,
                'fontSize' => 16
            ]
        ]);
        return $chart;
    }
    public static function getPieChart(string $name, $chartData)
    {
        $labels = $chartData->collapse()->keys()->toArray();
        $data = $chartData->collapse()->values();
        $colors = self::getColorsForChart(count($labels));

        $chart = app()->chartjs
        ->name($name)
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels($labels)
        ->datasets([
            [
                'label' => $name,
                'backgroundColor' => $colors,
                'data' => $data
            ],
        ])
        ->optionsRaw([
            'legend' => [
                'position' => 'right'
            ],
            'title' => [
                'display' => true,
                'text' => $name,
                'fontSize' => 16
            ]
        ]);
        return $chart;
    }
}
