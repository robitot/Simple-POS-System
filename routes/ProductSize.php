<?php

use Illuminate\Support\Facades\Route;

Route::get('/product-size', function () {
    return view('productSize.productSize');
})
    ->name('productSize')
    ->middleware(['auth', 'role:admin']);

Route::get('/product-size/create', function () {
    return view('productSize.create');
})
    ->name('productSize.craete')
    ->middleware(['auth', 'role:admin']);

Route::get('/product-size/edit/{id}', function ($id) {
    return view('productSize.edit', ['sizeId' => $id]);
})
    ->name('productSize.edit')
    ->middleware(['auth', 'role:admin']);
