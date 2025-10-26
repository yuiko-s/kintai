<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminAttendanceListController;
use App\Http\Controllers\LoginController;

Route::get('/register', [RegisterController::class,'register'])->name('register');
Route::post('/register', [RegisterController::class,'store'])->name('register.store');

Route::get('/admin', [AdminController::class,'admin'])->name('admin');
Route::post('/admin', [AdminController::class,'store'])->name('admin.store');

Route::get('/login', [LoginController::class,'login'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');;

Route::get('/attendance', [AttendanceController::class,'index'])->name('index');

Route::get('/admin/attendance/list', [AdminAttendanceListController::class,'index'])->name('index');