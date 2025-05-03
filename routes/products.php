<?php

use Illuminate\Support\Facades\Route;

//products
Route::get('/products', function () {
    return view('products.products');
})
    ->name('products')
    ->middleware(['auth', 'role:admin']);

Route::get('/products/create', function () {
    return view('products.create');
})
    ->name('products.create')
    ->middleware(['auth', 'role:admin']);

Route::get('/products/edit/{id}', function ($id) {
    return view('products.edit', ['productId' => $id]);
})->name('products.edit')->middleware(['auth', 'role:admin']);
