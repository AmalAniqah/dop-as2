<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CustomVerifyEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Auth\VerifyEmailController;
use Livewire\Volt\Volt;

// ---------------------
// Registration
// ---------------------
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    event(new Registered($user));

    // Auto-login the user
    Auth::login($user);

    // Redirect to verification notice
    return redirect()->route('verification.notice');
})->middleware('guest');

// ---------------------
// Guest routes
// ---------------------
Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')->name('login');
    Volt::route('register', 'auth.register')->name('register');
    Volt::route('forgot-password', 'auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'auth.reset-password')->name('password.reset');
});

// ---------------------
// Auth routes (verified)
// ---------------------
Route::middleware('auth')->group(function () {

    // Verification notice page
    Volt::route('verify-email', 'auth.verify-email')->name('verification.notice');

    // Verification link from email
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Resend verification link using PB custom email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->notify(new CustomVerifyEmail());
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    // Confirm password (optional)
    Volt::route('confirm-password', 'auth.confirm-password')->name('password.confirm');
});

// ---------------------
// Logout
// ---------------------
Route::post('logout', App\Livewire\Actions\Logout::class)->name('logout');
