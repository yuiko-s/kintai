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
        $cursor = $startOfMonth->copy();
        while($cursor <= $endOfMonth){
            $days[] = $cursor->copy();
            $cursor->addDay();
        }

        

       //一日の出勤データ取得
       $attendance = Attendance::where('user_id', $user->id)->first();

       



    //出勤データ取得
    //$rows = []; 
    //foreach($days as $day){
        //$dateKey = $day->format('Y-m-d');
        //$attendance = Attendance::where('user_id',$user->id)
            //->whereDate('start_time', $day->format('Y-m-d')) ->first();

        //if($attendance){
        //if($attendance->start_time && $attendance->end_time){
        //$worktime =  $attendance->start_time->diffInMinutes($attendance->end_time);
        //} else {
            
          //  $worktime = null;
        //}
    //}else{
      //  $worktime = null;
    //}


    //休憩
    //$breakMinutes = 0;
    //if($attendance){
      //  $breakstart = Breaktime::where('attendance_id',$attendance->id)
        //    ->whereDate('break_start', $day->format('Y-m-d')) ->first();
            
        
        //$breakend = Breaktime::where('attendance_id',$attendance->id)
          //  ->whereDate('break_end', $day->format('Y-m-d')) ->first();
           // } else {    
             //   $breakstart = null;
               // $breakend = null;
            //}
    
      //  if ($breakstart && $breakend) {
      //  $breakMinutes = $breakend->break_end->diffInMinutes($breakstart->break_start);
        //} else {

        //$breakMinutes = 0;

        //}

        //合計時間
        //$total = $worktime - $breakMinutes;
        //$total = Carbon::createFromTime(0,0)->addMinutes($total);
    //}
        
      


    //return view('attendancelist',
    //['today' => $today,
     //'day' => $day,
     //'days' => $days,
     //'year' => $year,
     //'month' => $month,
     //'attendance' => $attendance,
     //'breakMinutes' => $breakMinutes,
     //'total' => $total
    //]);
    }

    //追加登録ページ
    public function add()
    {
        return view('attendancedetailcreate');
    }

    //追加機能
    public function create(Request $request){
        $user = Auth::user();
        $attendance = Attendance::create([
        'user_id'    => $user->id,
        'start_time' => $request->start_time
            ? Carbon::parse($request->work_date.' '.$request->start_time)
            : null,
        'end_time'   => $request->end_time
            ? Carbon::parse($request->work_date.' '.$request->end_time)
            : null,
        'note'       => $request->note ?? null,
    ]);

    if ($request->break_start && $request->break_end) {
        BreakTime::create([
            'attendance_id' => $attendance->id,
            'break_start'   => Carbon::parse($request->work_date.' '.$request->break_start),
            'break_end'     => Carbon::parse($request->work_date.' '.$request->break_end),
            ]);
        }
        return redirect()->route('attendancelist.index');
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

