<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;

// Dashboard route (only for verified users)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Root redirect: determine where users should go
Route::get('/', function (Request $request) {
    if (auth()->check()) {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->route('dashboard')
            : redirect()->route('verification.notice'); // unverified users
    }
    return redirect()->route('login'); // guests
});

// Include default Laravel auth routes (handles register, login, logout, password, email verification)
require __DIR__.'/auth.php';
