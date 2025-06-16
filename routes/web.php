<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalaryController;

// Route utama: tampilkan welcome jika belum login, dashboard jika sudah login
Route::get('/', function () { 
    return view('welcome'); 
})->middleware('guest')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('transactions', TransactionController::class)->except(['show', 'create', 'edit']);
    // Ganti '/' menjadi '/dashboard' agar tidak bentrok dengan guest
    Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard');
    Route::resource('salaries', SalaryController::class)->only(['index', 'create', 'store']);
    Route::resource('budgets', BudgetController::class)->only(['index', 'create', 'store']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});

