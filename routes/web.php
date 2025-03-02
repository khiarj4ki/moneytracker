<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Redirect halaman utama (/) ke Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard Route
Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard');

// Transactions Routes
Route::get('/transactions', [TransactionController::class, 'show'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
