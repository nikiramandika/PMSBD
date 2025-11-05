<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::get('/treatments', [AdminController::class, 'treatments'])->name('treatments');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/cancellation-logs', [AdminController::class, 'cancellationLogs'])->name('cancellation-logs');
    Route::post('/transactions/{id}/cancel', [AdminController::class, 'cancelTransaction'])->name('transactions.cancel');
});

// Kasir Routes
Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');
    Route::get('/transactions/create', [KasirController::class, 'createTransaction'])->name('transactions.create');
    Route::post('/transactions', [KasirController::class, 'storeTransaction'])->name('transactions.store');
    Route::get('/transactions', [KasirController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/{id}', [KasirController::class, 'showTransaction'])->name('transactions.show');
    Route::post('/transactions/{id}/cancel', [KasirController::class, 'cancelTransaction'])->name('transactions.cancel');
    Route::get('/customers', [KasirController::class, 'customers'])->name('customers');
    Route::get('/treatments', [KasirController::class, 'treatments'])->name('treatments');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
