<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {return view('auth.login');})->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {return view('auth.register');})->name('register');
Route::post('/register', [AuthController::class, 'register']);
// Route::group(['middleware' => 'auth','check_role:admin,staff'], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index']);
// });
Route::middleware(['auth', 'check_role:customer'])->group(function () {
    Route::get('/verify', [VerificationController::class, 'index']);
    Route::post('/verify', [VerificationController::class, 'store']);
    Route::get('/verify/{unique_id}', [VerificationController::class, 'show']);
    Route::put('/verify/{unique_id}', [VerificationController::class, 'update']);
});
Route::middleware(['auth', 'check_role:customer', 'check_status'])->group(function () {
    Route::get('/customer', fn () => 'halaman customer');
});
Route::middleware(['auth', 'check_role:admin,staff'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
Route::middleware(['auth', 'check_role:admin'])->group(function () {
    Route::get('/user', fn () => 'halaman user');
});
Route::get('/logout', [AuthController::class, 'logout']);

// Route::get('/test-email', function () {
//     Mail::raw('Test email', function ($m) {
//         $m->to('proflewdietrich@gmail.com')
//             ->subject('Test SMTP');
//     });
//     return 'Email sent';
// });