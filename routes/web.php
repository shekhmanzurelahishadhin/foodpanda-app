<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SSOController;
use App\Http\Controllers\AuthController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
Route::get('/sso-login', [SSOController::class, 'handle'])->name('sso.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/', function () {
    return redirect()->route('dashboard');
});


