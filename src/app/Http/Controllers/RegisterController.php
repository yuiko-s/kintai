<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;


class RegisterController extends Controller
{
    //画面表示
    public function register()
    {
        return view('register');
    }

    //追加機能
    public function store(RegisterRequest $request)

    {
        $data = $request->validated();

        $user = User::create([
        'name' => $request->name, 
        'email' => $request->email, 
        'password' => Hash::make($request->password),
        'is_admin' => 0,
        ]);

        Auth::login($user);

        return redirect('/attendance');
    }
}