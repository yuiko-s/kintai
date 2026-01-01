<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
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

        

       //一日の出勤データ取得
       $date = $startOfMonth;
       $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('start_time' , $date)
            ->first();
       
        //休憩時間合計
        $breakTimes = $attendance ? $attendance->breakTimes : collect();

        $breakMinutes = $breakTimes->sum(fn($break) =>
        $break->break_start ? $break->break_start->diffInMinutes($break->break_end) : 0
);


        //実働時間
        $workMinutes = 0;

        if ($attendance && $attendance->start_time && $attendance->end_time) {
            $worked = $attendance->start_time->diffInMinutes($attendance->end_time);
            $workMinutes = max(0, $worked - $breakMinutes);
        }

        

            
       return view('attendancelist',
    ['today' => $today,
     'day' => $day,
     'days' => $days,
     'year' => $year,
     'month' => $month,
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
        return view('attendancedetail', [
            'attendance' => $attendance
        ]);
        } else {
        return redirect()->route('attendancedetail.create');
        }
    }

    //更新機能
    public function update(Request $request)
    {
        $form = $request->all();
        unset($form['_token']);
        Attendance::find($request->id)->update($form);
        return redirect()->route('attendancelist.index');   
    }
}
