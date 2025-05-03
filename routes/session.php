<?php

use Illuminate\Support\Facades\Route;

Route::get('/sessions', function () {
    return view('Session.sessions');
})->name('session')->middleware(['auth', 'role:admin,cashier,admin_assistan']);
