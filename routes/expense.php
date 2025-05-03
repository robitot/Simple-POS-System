<?php

use Illuminate\Support\Facades\Route;

Route::get('/expenses', function () {
    return view('expense.expense');
})->name('expense')->middleware('auth');

Route::get('/expenses/create', function () {
    return view('expense.create-expense');
})->name('expense.create')->middleware('auth');


Route::get('/expense/view/{id}', function ($id) {
    return view('expense.view-expense', ['expenseId' => $id]);
})->name('expense.view')->middleware('auth');
