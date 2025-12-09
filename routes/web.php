<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMemberController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::post('/login', [LoginController::class, 'handleLogin'])->name('login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); 

Route::resource('data_member',DataMemberController::class);

Route::resource('member', DataMemberController::class);


// Route::get('/data_member/{id}', [DataMemberController::class, 'show'])->name('data_member.show');




// Route::get('/data_member/{data_member}', [DataMemberController::class, 'show'])
//     ->name('data_member.show');

