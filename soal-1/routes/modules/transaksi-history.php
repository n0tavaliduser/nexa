<?php

use App\Http\Controllers\TransaksiHController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('transaksi_h')->name('transaksi_h.')->group(function () {
    Route::get('/', [TransaksiHController::class, 'index'])->name('index');
    Route::get('/get-datatable-data', [TransaksiHController::class, 'getDatatableData'])->name('getDatatableData');
    Route::get('/create', [TransaksiHController::class, 'create'])->name('create');
    Route::post('/', [TransaksiHController::class, 'store'])->name('store');
    Route::get('/{transaksiH}', [TransaksiHController::class, 'show'])->name('show');
    Route::get('/{transaksiH}/edit', [TransaksiHController::class, 'edit'])->name('edit');
    Route::put('/{transaksiH}', [TransaksiHController::class, 'update'])->name('update');
    Route::delete('/{transaksiH}', [TransaksiHController::class, 'destroy'])->name('destroy');
});
?>