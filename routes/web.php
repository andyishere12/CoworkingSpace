<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OperationalHoursController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AttendanceController; 

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', [LoginController::class, 'handleLogin'])->name('login.process');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Attendance (Hadir)
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('hadir.index');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');


    Route::resource('data_member', DataMemberController::class);
    Route::resource('reservasi', ReservasiController::class);
    Route::resource('room', RoomController::class);
    Route::resource('event', EventController::class);

    // Scan
    Route::get('/scan', [ScanController::class, 'index'])->name('scan');
    Route::post('/scan/store', [ScanController::class, 'store'])->name('scan.store');

    // Operational Hours
    Route::prefix('operational-hours')->name('operational-hours.')->group(function () {
        Route::get('/', [OperationalHoursController::class, 'index'])->name('index');
        Route::get('/edit', [OperationalHoursController::class, 'edit'])->name('edit');
        Route::put('/update-all', [OperationalHoursController::class, 'updateAll'])->name('update-all');
    });

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
