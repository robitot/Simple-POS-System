<?php

use Illuminate\Support\Facades\Route;

Route::get('/sessions', function () {
    return view('Session.sessions');
})->name('session')->middleware(['auth', 'role:admin,cashier,admin_assistan']);

Route::get('/sessions/Orders/{id}', function ($id) {
    return view('Session.details', ['id' => $id]);
})->name('session.details')->middleware(['auth', 'role:admin']);
