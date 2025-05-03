<?php

use Illuminate\Support\Facades\Route;

Route::get('/user', function () {
    return view('user.user');
})
    ->name('user')
    ->middleware(['auth', 'role:admin,admin_assistant']);

Route::get('/user/create', function () {
    return view('user.create-user');
})
    ->name('user.create')
    ->middleware(['auth', 'role:admin,admin_assistant']);

//inventory
Route::get('/inventory', function () {
    return view('inventory.inventory');
})
    ->name('inventory')
    ->middleware(['auth', 'role:admin,admin_assistant']);

Route::get('/inventory/create', function () {
    return view('inventory.create-inventory');
})
    ->name('inventory.create')
    ->middleware(['auth', 'role:admin,admin_assistant']);

Route::get('/inventory/edit/{id}', function ($id) {
    return view('inventory.edit-inventory', ['inventoryId' => $id]);
})->name('inventory.edit')->middleware(['auth', 'role:admin,admin_assistant']);