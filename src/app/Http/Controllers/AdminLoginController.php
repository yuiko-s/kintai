<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index(){
        return view('adminlogin');
}
    public function login(LoginRequest $request){
        $credentials=$request->only('email', 'password');
        $credentials['is_admin']=1;

        
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('adminattendancelist.index');
        }
    
        
        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/adminlogin');
    }
}