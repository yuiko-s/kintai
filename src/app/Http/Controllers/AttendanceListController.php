<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;

class AttendanceListController extends Controller
{
    public function index()
    {  
        Carbon::setLocale('ja');

        $user = Auth::user();
        
    //カレンダー
        $today = Carbon::now();      
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

        

    //出勤データ取得
        
        $attendance = Attendance::where('user_id',$user->id)
            ->whereDate('start_time', $day->format('Y-m-d')) ->first();

        if($attendance){
        if($attendance->start_time && $attendance->end_time){
        $worktime =  $attendance->start_time->diffInMinutes($attendance->end_time);
        } else {
            
            $worktime = null;
        }
    }else{
        $worktime = null;
    }


    //休憩
        if($attendance){
        $breakstart = Breaktime::where('attendance_id',$attendance->id)
            ->whereDate('break_start', $day->format('Y-m-d')) ->first();
            
        
        $breakend = Breaktime::where('attendance_id',$attendance->id)
            ->whereDate('break_end', $day->format('Y-m-d')) ->first();
            } else {    
                $breakstart = null;
                $breakend = null;
            }
    
        if ($breakstart && $breakend) {
        $breaktime = $breakend->diffInMinutes($breakstart);
        $breaktime = Carbon::createFromTime(0,0)->addMinutes($break_minutes);
        } else {

        $breaktime = null;

        }

        //合計時間
        $total = $worktime - $breaktime;
        $total = Carbon::createFromTime(0,0)->addMinutes($total);
       


    return view('attendancelist',
    ['today' => $today,
     'day' => $day,
     'days' => $days,
     'year' => $year,
     'month' => $month,
     'attendance' => $attendance,
     'breaktime' => $breaktime,
     'total' => $total
]);
    }
}
