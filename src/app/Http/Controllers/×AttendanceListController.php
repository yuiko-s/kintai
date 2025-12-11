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
            ->with('breakTimes')
            ->get()
            ->keyBy(function ($attendance) {
        return $attendance->start_time->toDateString();
    });

        //休憩＋合計
        $breakMinutesByDate = [];
        $workTimeTextByDate = [];

        foreach ($attendances as $attendance) {
            $dateKey = $attendance->start_time->toDateString();
            $totalBreakMinutes = 0;

            foreach ($attendance->breakTimes as $break) {
                if ($break->break_start && $break->break_end) {
                    $totalBreakMinutes += $break->break_start->diffInMinutes($break->break_end);
                }
            }
            $breakMinutesByDate[$dateKey] = $totalBreakMinutes;
            

            $workedMinutes = 0;
            if ($attendance->start_time && $attendance->end_time) {
            $workedMinutes = $attendance->start_time->diffInMinutes($attendance->end_time);
            }
 

            $actualWorkedMinutes = max($workedMinutes - $totalBreakMinutes, 0);
            
            $hours   = intdiv($actualWorkedMinutes, 60);
            $minutes = $actualWorkedMinutes % 60;

            $workTimeTextByDate[$dateKey] = sprintf('%d:%02d', $hours, $minutes);
    }   

        return view('attendancelist',[
            'year'        => $year,
            'month'       => $month,
            'days'        => $days,
            'attendances' => $attendances,
            'breakMinutesByDate' => $breakMinutesByDate,
            'workTimeTextByDate' => $workTimeTextByDate,
        ]);
    }
    
}
