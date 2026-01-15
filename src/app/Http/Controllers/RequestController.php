<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Approval;
use App\Models\User;

class RequestController extends Controller
{
    public function index(Request $request){

    $user = auth()->user(); 
    $tab  = $request->query('tab', 'pending');

    if ($tab === 'pending') {
    $approvals = Approval::where('user_id', $user->id)
        ->where('status', 'pending')
        ->get();
        } else {
    $approvals = Approval::where('user_id', $user->id)
        ->where('status', 'approved')
        ->get();
    }

    $attendances = Attendance::where('user_id', $user->id)->get();

    return view('request', [
            'tab' => $tab,
            'approvals' => $approvals,
            'attendances' => $attendances,
        ]);
    }

}
