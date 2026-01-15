<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    public function index(){
        
        Carbon::setLocale('ja');

        $user = Auth::user();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('start_time', Carbon::today())
            ->latest('start_time')
            ->first();

        $status = null;

        // 0: 出勤中, 1: 休憩中, 2: 出勤外 ,　3:退勤済
        
        if (!$attendance) {
            $status = 2;

            } else {
                if (is_null($attendance->end_time)) {

                $onBreak = $attendance->breaktimes()
                    ->whereNull('break_end')
                    ->exists();

                $status = $onBreak ? 1 : 0;

                    } else {
                        $status = 3;
                    }
                }
        
        $now = Carbon::now();

        $today = $now->isoFormat('YYYY年MM月DD日(ddd)');
        $totime = $now->format('H:i');

        return view('attendance',[
        'today' => $today,
        'totime' => $totime,
        'status' => $status,
        'attendance' => $attendance]);
    }

    //出勤打刻

   public function clockIn(){
        $user = auth()->user();
        Attendance::firstOrCreate([
            'user_id' => $user->id,
            'start_time' => now(), 
        ]);
        return redirect('attendance');
   } 

   //退勤打刻
 
    public function clockOut(){
        $user = auth()->user();

        $attendance = Attendance::where('user_id', $user->id)
        ->whereDate('start_time', Carbon::today())
        ->latest('start_time')
        ->first();

        if ($attendance) {
        $attendance->update([
            'end_time' => now(),
        ]);

        return redirect('attendance');
        }
    }

}