<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/absen', [AbsenController::class, 'index'])->name('absen.index');
    Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');

    Route::get('/riwayat', [AbsenController::class, 'riwayat'])->name('absen.riwayat');
});

require __DIR__ . '/auth.php';
