<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMemberController;
use App\Http\Controllers\ReservasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;


Route::get('/', function () {
    return view('auth.login');
});

Route::post('/login', [LoginController::class, 'handleLogin'])->name('login');

Route::middleware('auth')->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('data_member', DataMemberController::class);

Route::resource('reservasi',ReservasiController::class);

Route::get('/scan', [ScanController::class, 'index'])->name('scan');
Route::post('/scan/store', [ScanController::class, 'store'])->name('scan.store');

});







