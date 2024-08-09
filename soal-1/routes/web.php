<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    require __DIR__ . '/modules/transaksi-history.php';
    require __DIR__ . '/modules/transaksi-detail.php';
    require __DIR__ . '/modules/ms-customer.php';
});
