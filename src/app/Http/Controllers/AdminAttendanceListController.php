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

//詳細ページ表示
    public function detail($id){
        $attendance = Attendance::find($id);
        if ($attendance) {
            $breakTimes = $attendance->breakTimes()->take(2)->get();
            while ($breakTimes->count() < 2) {
            $breakTimes->push(new \App\Models\BreakTime());
    }
        return view('adminattendance', [
            'attendance' => $attendance,
            'breakTimes' => $breakTimes,
        ]);
        } else {
        return redirect()->route('adminattendancelist.index');
        }
    }

    //更新機能
    public function update(Request $request)
    {
        $form = $request->all();
        unset($form['_token']);
        Attendance::find($request->id)->update($form);
        return redirect()->route('adminattendancelist.index');   
    }
}