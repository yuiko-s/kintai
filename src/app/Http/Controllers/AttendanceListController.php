<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ApprovalRequest;
use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\Approval;
use Carbon\Carbon;


class AttendanceListController extends Controller
{
    public function index(Request $request)
    {  
        Carbon::setLocale('ja');

        $user = Auth::user();

        $monthParam = $request->query('month');
        
    //カレンダー
        $today = $monthParam
        ? Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth()
        : Carbon::now()->startOfMonth();      
        $year = $today->year;
        $month = $today->month;

        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

    //日付
        $day = $startOfMonth->copy();
        while($day <= $endOfMonth){
            $days[] = $day->copy();
            $day->addDay();
        }

        
        $attendanceByDate = [];
        $breakMinutesByDate = [];
        $workMinutesByDate = [];

        foreach ($days as $date) {
        $key = $date->toDateString();
        
       //一日の出勤データ取得
       
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('start_time' , $date)
            ->first();
       
        $attendanceByDate[$key] = $attendance;
            
        //休憩時間合計
        $breakTimes = $attendance ? $attendance->breakTimes : collect();

        $breakMinutes = $breakTimes->sum(fn($break) =>
        ($break->break_start && $break->break_end) ? $break->break_start->diffInMinutes($break->break_end) : 0
);
        $breakMinutesByDate[$key] = max(0, $breakMinutes);


        //実働時間
        $workMinutes = 0;

        if ($attendance && $attendance->start_time && $attendance->end_time) {
            $worked = $attendance->start_time->diffInMinutes($attendance->end_time);
            $workMinutes = max(0, $worked - $breakMinutes);
        }
   
        $workMinutesByDate[$key] = $workMinutes;
        }
        return view('attendancelist',
        ['today' => $today,
        'day' => $day,
        'days' => $days,
        'year' => $year,
        'month' => $month,
        'attendanceByDate' => $attendanceByDate,
        'breakMinutesByDate' => $breakMinutesByDate,
        'workMinutesByDate' => $workMinutesByDate,
        'attendance' => $attendance,
        'breakTimes' => $breakTimes,
        'breakMinutes' => $breakMinutes,
        'workMinutes' => $workMinutes
        ]
);

    }   
    //詳細ページ表示
    public function detail($id){
        
        
        $attendance = Attendance::find($id);
        if ($attendance) {
            $breakTimes = $attendance->breakTimes()->take(2)->get();
            while ($breakTimes->count() < 2) {
            $breakTimes->push(new \App\Models\BreakTime());
    }
        return view('attendancedetail', [
            'attendance' => $attendance,
            'breakTimes' => $breakTimes,
            'approval'   => $attendance->approvals()->latest()->first(),
        ]);
        } else {
        return redirect()->route('attendancedetail.create');
        }
    }

    //更新機能
    public function update(ApprovalRequest $request)
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

        return redirect()->route('attendancelist.index');
}

}