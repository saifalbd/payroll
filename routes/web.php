<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', [AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/', [AuthController::class, 'login'])->name('login.post');



Route::prefix('/home')->middleware('auth:employee')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'home'])->name('home');
});
