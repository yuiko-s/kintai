<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\User;

class AttendanceDetailController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $attendance = Attendance::where('user_id',$user->id)
        ->first();

        $breaktime = BreakTime::where('attendance_id',$attendance->id)
        ->first();


        return view('attendancedetail',[
        'name' => $user->name,
        'attendance' =>$attendance,
        'breaktime' =>$breaktime
    ]);
    }

    //更新
    public function update(Request $request)
    {
       
        $form = $request->all();
        unset($form['_token']);
        $attendance = Attendance::find($request->id)->update($form);
        return redirect('attendancelist');        
    }
}
