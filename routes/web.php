<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\TransaksiAsetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //Aset
    Route::resource('aset', AsetController::class);

    //Transaksi
    Route::resource('transaksi-aset', TransaksiAsetController::class);
    Route::get('transaksi-masuk', [TransaksiAsetController::class, 'masuk'])->name('transaksi.masuk');
    Route::get('transaksi-keluar', [TransaksiAsetController::class, 'keluar'])->name('transaksi.keluar');
    


});

require __DIR__.'/auth.php';