<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {return view('auth.login');})->name('login');
Route::post('/login', [AuthController::class, 'login']);
// Route::group(['middleware' => 'auth','check_role:admin,staff'], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index']);
// });
Route::middleware(['auth', 'check_role:customer'])->group(function () {
    Route::get('/customer', fn () => 'halaman customer');
});
Route::middleware(['auth', 'check_role:admin,staff'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
Route::middleware(['auth', 'check_role:admin'])->group(function () {
    Route::get('/user', fn () => 'halaman user');
});
Route::get('/logout', [AuthController::class, 'logout']);