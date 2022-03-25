<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Skill;
use App\Position;
use Carbon\CarbonPeriod;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $inputDates = $request->input('daterange');
        $beginEndDates = getBeginEndDates($inputDates);
        [$beginDate, $endDate] = $beginEndDates;

        $usersCountByDate = User::whereBetween('created_at', [$beginDate, $endDate])
            ->get()
            ->countBy(function($date) {
                return Carbon::parse($date->created_at)->format('d-m-Y');
            });

        $registrationCountInPeriod = collect(CarbonPeriod::create($beginDate, $endDate))
            ->map(function ($date) {
                return $date->format('d-m-Y');
            })
            ->flip()
            ->map(function ($item) {
                return $item = 0;
            })
            ->merge($usersCountByDate);

        $skillsByUsers = Skill::get()
            ->map(function ($skill) {
                return [$skill->skill_name => $skill->users()->count()];
            });

        $positionsByUsers = Position::get()
        ->map(function ($position) {
            return [$position->position_name => $position->users()->count()];
        });

        $registrationChart = getBarChart($inputDates, 'Registration', $registrationCountInPeriod);
        $skillsChart = getPieChart('Skills', $skillsByUsers);
        $positionsChart = getPieChart('Positions', $positionsByUsers);

        return view('statistic.index', compact('registrationChart', 'inputDates', 'positionsChart', 'skillsChart'));
    }
}
