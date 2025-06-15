<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// Mengarahkan halaman utama langsung ke daftar transaksi
Route::get('/', [TransactionController::class, 'index'])->name('home');

// Menggunakan resource controller untuk menangani semua aksi CRUD
// Ini akan secara otomatis membuat rute untuk index, create, store, show, edit, update, destroy
Route::resource('transactions', TransactionController::class);

