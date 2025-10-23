<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;


class AdminController extends Controller
{
    //画面表示
    public function admin()
    {
        return view('admin');
    }

    //追加機能
    public function store(RegisterRequest $request)

    {
        $data = $request->validated();

        $request->validate([
            'is_admin' => ['required', 'in:1'],
            ]);

        $user = User::create([
        'name' => $request->name, 
        'email' => $request->email, 
        'password' => Hash::make($request->password),
        'is_admin' => true,
        ]);

        Auth::login($user);

         if ($user->is_admin) {
            return redirect('/admin/attendance/list');
        } else {
            return redirect('/attendance');
        }
    
    }
}