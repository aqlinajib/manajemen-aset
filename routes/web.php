<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\TransaksiAsetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AktivitasController;

// Arahkan root (/) langsung ke halaman login
Route::get('/', function () {
    return redirect('/login');
});

// Dashboard: hanya bisa diakses jika sudah login dan terverifikasi
// Dashboard: arahkan ke DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route yang hanya bisa diakses oleh user yang sudah login
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Aset
    Route::resource('aset', AsetController::class);
    Route::post('/aset/import', [AsetController::class, 'import'])->name('aset.import');

    // Transaksi Aset
    Route::resource('transaksi-aset', TransaksiAsetController::class);
    Route::get('transaksi-masuk', [TransaksiAsetController::class, 'masuk'])->name('transaksi.masuk');
    Route::get('transaksi-keluar', [TransaksiAsetController::class, 'keluar'])->name('transaksi.keluar');

    // View all dan detail
    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');
});

// Include route auth (login, register, etc.)
require __DIR__.'/auth.php';