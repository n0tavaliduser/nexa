<?php

use App\Http\Controllers\MsCustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('ms_customer')->name('ms_customer.')->group(function () {
    Route::get('/', [MsCustomerController::class, 'index'])->name('index');
    Route::get('/create', [MsCustomerController::class, 'create'])->name('create');
    Route::post('/', [MsCustomerController::class, 'store'])->name('store');
    Route::get('/{msCustomer}', [MsCustomerController::class, 'show'])->name('show');
    Route::get('/{msCustomer}/edit', [MsCustomerController::class, 'edit'])->name('edit');
    Route::put('/{msCustomer}', [MsCustomerController::class, 'update'])->name('update');
    Route::delete('/{msCustomer}', [MsCustomerController::class, 'destroy'])->name('destroy');
    Route::get('/{msCustomer}/info', [MsCustomerController::class, 'getCustomerInfo'])->name('info');
    Route::get('/get-customer-info', [MsCustomerController::class, 'getCustomerInfo'])->name('get-customer-info');
});
?>