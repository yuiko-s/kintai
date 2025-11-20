<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BreakTimeController extends Controller
{
    
    //休憩入打刻
 
    public function breakIn(){
        $user = auth()->user();

        $attendance = Attendance::where('user_id', $user->id)
        ->whereDate('start_time', Carbon::today())
        ->whereNull('end_time')
        ->latest('start_time')
        ->first();  

        if (!$attendance) {
        return back()->with('error', '出勤中ではありません。');
    }

     $onBreak = $attendance->breaktimes()
        ->whereNull('break_end')
        ->exists();

    if ($onBreak) {
        return back()->with('error', 'すでに休憩中です。');
    }

    $attendance->breaktimes()->create([
        'user_id'       => $user->id,
        'break_start'   => now(),
        'break_end'     => null,
    ]);

    return redirect()->route('attendance.index');

        }
    

    //休憩戻打刻
 
    public function breakOut(){
        $user = auth()->user();

        $attendance = Attendance::where('user_id', $user->id ,)
        ->whereDate('start_time', Carbon::today())
        ->whereNull('end_time')
        ->latest('start_time')
        ->first();

        $breaktime = $attendance->breaktimes()
            ->whereNull('break_end')
            ->latest('break_start')
            ->first();
        
    if ($breaktime) {
        $breaktime->update([
        'break_end' => now(),
    ]);

        return redirect()->route('attendance.index');
        }
    }
}
