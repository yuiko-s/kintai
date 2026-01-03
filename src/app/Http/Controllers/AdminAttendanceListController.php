<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;


class AdminAttendanceListController extends Controller
{
     public function index(Request $request)
{
    Carbon::setLocale('ja');

    $today = Carbon::today(); 

    
    $attendances = Attendance::with(['user', 'breakTimes'])
        ->whereDate('start_time', $today)
        ->get();

    
    $breakMinutesByAttendanceId = [];
    $workMinutesByAttendanceId  = [];

    foreach ($attendances as $attendance) {
        $breakMinutes = $attendance->breakTimes->sum(function ($break) {
            return ($break->break_start && $break->break_end)
                ? $break->break_start->diffInMinutes($break->break_end)
                : 0;
        });

        $breakMinutesByAttendanceId[$attendance->id] = max(0, $breakMinutes);

        $workMinutes = 0;
        if ($attendance->start_time && $attendance->end_time) {
            $worked = $attendance->start_time->diffInMinutes($attendance->end_time);
            $workMinutes = max(0, $worked - $breakMinutesByAttendanceId[$attendance->id]);
        }
        $workMinutesByAttendanceId[$attendance->id] = $workMinutes;
    }

    return view('admin.attendance.list', [
        'today' => $today,
        'attendances' => $attendances,
        'breakMinutesByAttendanceId' => $breakMinutesByAttendanceId,
        'workMinutesByAttendanceId' => $workMinutesByAttendanceId,
    ]);
}

}