<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\User;
use Carbon\Carbon;

class AdminAttendanceStaffController extends Controller
{
    public function index(Request $request, User $user)
    {  
        Carbon::setLocale('ja');

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
        return view('adminattendancestaff',
        ['user' => $user,
        'today' => $today,
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
        return view('adminattendancestaff', [
            'attendance' => $attendance,
            'breakTimes' => $breakTimes,
        ]);
        } else {
        return redirect()->route('adminstafflist');
        }
    }
}

