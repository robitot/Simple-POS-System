<?php

use Illuminate\Support\Facades\Route;

Route::get('/categories', function () {
    return view('category.category');
})->name('category')->middleware(['auth', 'role:admin']);

Route::get('/category/create', function () {
    return view('category.create-category');
})->name('category.create')->middleware(['auth', 'role:admin']);
