<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminStaffListController extends Controller
{
    public function index(){

        $users = User::all();

        return view('adminstafflist',
        ['users' => $users]);
}

//詳細ページ表示
    public function detail($id){
        $user = User::find($id);
        if ($user) {
            $breakTimes = $attendance->breakTimes()->take(2)->get();
            while ($breakTimes->count() < 2) {
            $breakTimes->push(new \App\Models\BreakTime());
    }
        return view('adminattendancestaff.index', [
            'attendance' => $attendance,
            'breakTimes' => $breakTimes,
        ]);
        } else {
        return redirect()->route('adminstafflist.index');
        }
    }

    
}