<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $inputDates = $request->input('daterange');
        $arrDates = explode('-', $inputDates);
        $beginDate = Carbon::parse($arrDates[0]) ?? Carbon::now();
        $endDate = Carbon::now();

        $usersByDate = User::whereBetween('created_at', [$beginDate, $endDate])
            ->get();

        $chartjs = app()->chartjs
        ->name('Registration')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Label x'])
        ->datasets([
            [
                "label" => "Registration",
                'backgroundColor' => '#3490E1',
                'data' => [69, 59]
            ],
        ])
        ->options([]);

        return view('statistic.index', compact('chartjs', 'inputDates', 'usersByDate'));
    }
}
