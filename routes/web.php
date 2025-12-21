<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OperationalHoursController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::post('/login', [LoginController::class, 'handleLogin'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('data_member', DataMemberController::class);

    Route::resource('reservasi', ReservasiController::class);

    Route::resource('room', RoomController::class);

    Route::resource('event', EventController::class);

    // Operational Hours Routes
    Route::prefix('operational-hours')->name('operational-hours.')->group(function () {
        Route::get('/', [OperationalHoursController::class, 'index'])->name('index');
        Route::get('/edit', [OperationalHoursController::class, 'edit'])->name('edit');
        Route::put('/update-all', [OperationalHoursController::class, 'updateAll'])->name('update-all');
    });

    // ==========================================
    // REPORTS ROUTES - TAMBAHAN BARU
    // ==========================================
    Route::prefix('reports')->name('reports.')->group(function () {
        // Halaman index laporan
        Route::get('/', [ReportController::class, 'index'])->name('index');

        // Laporan Membership
        Route::get('/membership', [ReportController::class, 'membershipReport'])->name('membership');

        // Laporan Ruangan
        Route::get('/room', [ReportController::class, 'roomReport'])->name('room');

        // Laporan Event
        Route::get('/event', [ReportController::class, 'eventReport'])->name('event');

        // Export Routes
        Route::get('/export/membership', [ReportController::class, 'exportMembership'])->name('export.membership');
        Route::get('/export/room', [ReportController::class, 'exportRoom'])->name('export.room');
        Route::get('/export/event', [ReportController::class, 'exportEvent'])->name('export.event');
    });


    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});
