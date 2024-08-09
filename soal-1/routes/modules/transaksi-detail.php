<?php

use App\Http\Controllers\TransaksiDController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('transaksi_d')->name('transaksi_d.')->group(function () {
    Route::get('/', [TransaksiDController::class, 'index'])->name('index');
    Route::get('/create', [TransaksiDController::class, 'create'])->name('create');
    Route::post('/', [TransaksiDController::class, 'store'])->name('store');
    Route::get('/{transaksiD}', [TransaksiDController::class, 'show'])->name('show');
    Route::get('/{transaksiD}/edit', [TransaksiDController::class, 'edit'])->name('edit');
    Route::put('/{transaksiD}', [TransaksiDController::class, 'update'])->name('update');
    Route::delete('/{transaksiD}', [TransaksiDController::class, 'destroy'])->name('destroy');
});
?>