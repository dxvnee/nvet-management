<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/penggajian/{penggajian}/print', [PenggajianController::class, 'print'])->name('penggajian.print');

    // Routes untuk pegawai
    Route::middleware('role:pegawai')->group(function () {
        Route::get('/absen', [AbsenController::class, 'index'])->name('absen.index');
        Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');
        Route::get('/riwayat', [AbsenController::class, 'riwayat'])->name('absen.riwayat');
        Route::get('/riwayat-kalender', [AbsenController::class, 'riwayatKalender'])->name('absen.riwayatKalender');
        Route::get('/penggajian-riwayat', [PenggajianController::class, 'riwayatPegawai'])->name('penggajian.riwayat');

        // Lembur Pegawai
        Route::get('/lembur', [LemburController::class, 'index'])->name('lembur.index');
        Route::post('/lembur', [LemburController::class, 'store'])->name('lembur.store');
        Route::patch('/lembur/{lembur}', [LemburController::class, 'update'])->name('lembur.update');
    });

    // Routes untuk admin
    Route::middleware('role:admin')->group(function () {
        // User Management Routes
        Route::resource('users', UserController::class);

        // Penggajian Routes
        Route::resource('penggajian', PenggajianController::class);

        // Lembur Admin
        Route::get('/lembur-admin', [LemburController::class, 'adminIndex'])->name('lembur.admin');
        Route::patch('/lembur/{lembur}/approve', [LemburController::class, 'approve'])->name('lembur.approve');
        Route::patch('/lembur/{lembur}/reject', [LemburController::class, 'reject'])->name('lembur.reject');

        // Hari Libur Routes
        Route::resource('hari-libur', HariLiburController::class)->except(['show']);

        // Absensi Kalender Routes
        Route::get('/absensi-kalender', [AbsenController::class, 'kalender'])->name('absen.kalender');
        Route::get('/absensi-kalender/{tanggal}', [AbsenController::class, 'detailHari'])->name('absen.detailHari');
        Route::get('/absensi/user', [AbsenController::class, 'absensiUser'])->name('absen.user');
        Route::get('/absen/create/{tanggal}/{user}', [AbsenController::class, 'create'])->name('absen.create');
        Route::post('/absen/manual', [AbsenController::class, 'storeManual'])->name('absen.storeManual');
        Route::get('/absen/{absen}/edit', [AbsenController::class, 'edit'])->name('absen.edit');
        Route::patch('/absen/{absen}', [AbsenController::class, 'update'])->name('absen.update');
        Route::delete('/absen/{absen}', [AbsenController::class, 'destroy'])->name('absen.destroy');
    });
});

require __DIR__ . '/auth.php';
