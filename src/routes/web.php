<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminAttendanceListController;
use App\Http\Controllers\AttendanceListController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BreakTimeController;



Route::get('/register', [RegisterController::class,'register'])->name('register');
Route::post('/register', [RegisterController::class,'store'])->name('register.store');

Route::get('/admin', [AdminController::class,'admin'])->name('admin');
Route::post('/admin', [AdminController::class,'store'])->name('admin.store');

Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');



Route::middleware('auth')->group(function () {

Route::get('/attendance', [AttendanceController::class,'index'])->name('attendance.index');
Route::post('/clock-in', [AttendanceController::class, 'clockIn'])->name('attendances.clockin');
Route::post('/clock-out', [AttendanceController::class, 'clockOut'])->name('attendances.clockout');


Route::get('/breaktime', [BreakTimeController::class,'index'])->name('breaktime.index');
Route::post('/break-in',  [BreakTimeController::class, 'breakIn'])->name('breaktime.breakin');
Route::post('/break-out', [BreakTimeController::class, 'breakOut'])->name('breaktime.breakout');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/attendance/list', [AttendanceListController::class,'index'])->name('attendancelist.index');

Route::get('/attendance/detail/create', [AttendanceListController::class,'add'])->name('attendancedetail.add');
Route::post('/attendance/detail/create', [AttendanceListController::class,'create'])->name('attendancedetail.create');
Route::get('/attendance/detail/{id}', [AttendanceListController::class,'detail'])->name('attendancedetail.detail');
Route::post('/attendance/detail/{id}', [AttendanceListController::class,'update'])->name('attendancedetail.update');

});

Route::get('/admin/attendance/list', [AdminAttendanceListController::class,'index'])->name('admin.attendancelist.index');