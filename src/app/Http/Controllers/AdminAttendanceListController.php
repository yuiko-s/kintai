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
    $dayParam = $request->query('day');
    $today = $dayParam
        ? Carbon::createFromFormat('Y-m-d', $dayParam)
        : Carbon::today();

    
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

    return view('adminattendancelist', [
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

        $attendance = Attendance::findOrFail($request->id);

        
        $base = $attendance->start_time->format('Y-m-d');
        $attendance->start_time = $base . ' ' . $request->start_time;
        $attendance->end_time   = $base . ' ' . $request->end_time;
        $attendance->save();
        
        BreakTime::where('attendance_id', $attendance->id)->delete();

        $breakStarts = $request->input('break_start', []);
        $breakEnds   = $request->input('break_end', []);

        for ($i = 0; $i < count($breakStarts); $i++) {
        $bs = $breakStarts[$i] ?? null;
        $be = $breakEnds[$i] ?? null;

        if (!$bs && !$be) continue;

        $break = new BreakTime();
        $break->attendance_id = $attendance->id;
        $break->user_id       = $attendance->user_id;
        $break->break_start   = $bs ? ($base . ' ' . $bs) : null;
        $break->break_end     = $be ? ($base . ' ' . $be) : null;
        $break->save();
    }

        $attendance->approvals()->create([
            'user_id'       => $attendance->user_id,
            'attendance_id' => $attendance->id,
            'status'        => 'pending',
            'remarks'       => $request->input('remarks'),
        ]);


        return redirect()->route('adminattendancelist.index');
}
}