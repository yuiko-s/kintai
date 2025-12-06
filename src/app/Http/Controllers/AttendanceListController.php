<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceListController extends Controller
{
    public function index()
    {  
    //①カレンダー
        $today = Carbon::now();      
        $year = $today->year;
        $month = $today->month;

        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

    //②日付
        $day = $startOfMonth->copy();
        while($day <= $endOfMonth){
            $days[] = $day->copy();
            $day->addDay();
        }

        

    //③出勤・退勤・休憩


    return view('attendancelist',
    ['today' => $today,
     'day' => $day,
     'days' => $days,
     'year' => $year,
     'month' => $month
]);
    }
}
