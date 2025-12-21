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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

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

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('hadir.index');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');

    // Resources
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

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/membership', [ReportController::class, 'membershipReport'])->name('membership');
        Route::get('/room', [ReportController::class, 'roomReport'])->name('room');
        Route::get('/event', [ReportController::class, 'eventReport'])->name('event');

        Route::get('/export/membership', [ReportController::class, 'exportMembership'])->name('export.membership');
        Route::get('/export/room', [ReportController::class, 'exportRoom'])->name('export.room');
        Route::get('/export/event', [ReportController::class, 'exportEvent'])->name('export.event');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
