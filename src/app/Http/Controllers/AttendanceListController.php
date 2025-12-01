<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;

class AttendanceListController extends Controller
{
    public function index($year = null, $month = null)
    {
        $user = Auth::user();

        //表示月
        $today = now();
        $year  = $year  ?? $today->year;
        $month = $month ?? $today->month;

        //月初月末
        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        //日付
        $date = $startOfMonth->copy();
        while ($date->lte($endOfMonth)) {
        $days[] = $date->copy();
        $date->addDay();
        }

        //出勤
        $attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('start_time', [
                $startOfMonth->copy()->startOfDay(),
                $endOfMonth->copy()->endOfDay(),
            ])
            ->get()
            ->keyBy(function ($attendance) {
        return $attendance->start_time->toDateString();
        });

        //退勤
        $attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('end_time', [
                $startOfMonth->copy()->startOfDay(),
                $endOfMonth->copy()->endOfDay(),
            ])
            ->get()
            ->keyBy(function ($attendance) {
        return $attendance->end_time->toDateString();
        });

        return view('attendancelist',[
            'year'        => $year,
            'month'       => $month,
            'days'        => $days,
            'attendances' => $attendances,
        ]);
    }
}
