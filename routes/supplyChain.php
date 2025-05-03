<?php

use Illuminate\Support\Facades\Route;

//supply chain
Route::get('/supply-chain', function () {
    return view('supplyChain.supplyChain');
})
    ->name('supplyChain')
    ->middleware(['auth', 'role:admin,wh,admin_assistant'])->lazy();

Route::get('/supply-chain/create', function () {
    return view('supplyChain.create');
})
    ->name('supplyChain.create')
    ->middleware(['auth', 'role:admin,wh,admin_assistant']);
