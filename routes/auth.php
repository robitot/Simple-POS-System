<?php

use Illuminate\Support\Facades\Route;
use app\Livewire\Auth\Login;

// routes/web.php
Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::get('/forgotPassword', function () {
    return view('auth.forgotPassword');
})->name('forgotPassword')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})
    ->name('register')
    ->middleware('guest');

Route::get('/profile', function () {
    return view('auth.profile');
})
    ->name('profile')
    ->middleware(['auth', 'role:admin,admin_assistant']);

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})
    ->name('dashboard')
    ->middleware(['auth', 'role:admin,admin_assistant']);
