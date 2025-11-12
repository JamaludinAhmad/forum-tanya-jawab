<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerUser'])->name('registerUser');
});


Route::middleware(['auth'])->group(function () {
    // Protected routes for authenticated users can be added here
    Route::get('/', function () {
        return view('welcome');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

