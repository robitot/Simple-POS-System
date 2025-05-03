<?php

use Illuminate\Support\Facades\Route;

Route::get('/start-session', function () {
    return view('POS.start-session');
})->name('POS.start-session')->middleware(['auth', 'role:admin,cashier']);

Route::get('/end-session', function () {
    return view('POS.end-session');
})->name('POS.end-session')->middleware(['auth', 'role:admin,cashier']);

Route::get('/POS', function () {
    return view('POS.pos');
})->name('POS')->middleware(['auth', 'role:admin,cashier']);

Route::get('/checkout', function () {
    return view('POS.checkout');
})->name('POS.checkout')->middleware(['auth', 'role:admin,cashier']);
