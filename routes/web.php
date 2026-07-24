<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\KasirController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\LaporanKeluarController;
use App\Http\Controllers\Admin\ProfileSalonController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Public Reservasi Routes
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
Route::get('/reservasi/cek', [ReservasiController::class, 'cekStatus'])->name('reservasi.cek');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes (Prefix is used to separate UI)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->group(function () {
    Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('kasir.dashboard');
});

// Shared Admin Features (Prefix 'admin' for consistent URLs, available to both Admin & Kasir)
Route::middleware(['auth', 'role:admin,kasir'])->prefix('admin')->group(function () {
    // Kasir POS
    Route::get('/kasir', [KasirController::class, 'index'])->name('admin.kasir.index');
    Route::post('/kasir', [KasirController::class, 'store'])->name('admin.kasir.store');

    // Reservasi (Shared for Admin & Kasir)
    Route::get('/reservasi', [AdminReservasiController::class, 'index'])->name('admin.reservasi.index');
    Route::put('/reservasi/{id}/status', [AdminReservasiController::class, 'updateStatus'])->name('admin.reservasi.updateStatus');
    Route::delete('/reservasi/{id}', [AdminReservasiController::class, 'destroy'])->name('admin.reservasi.destroy');
    Route::get('/reservasi/{id}/kasir', [AdminReservasiController::class, 'prosesKeKasir'])->name('admin.reservasi.kasir');

    // Riwayat & Laporan
    Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('admin.riwayat.index');
    Route::get('/laporan/masuk', [TransaksiController::class, 'laporanMasuk'])->name('admin.laporan.masuk');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('admin.transaksi.show');
    Route::get('/transaksi/{id}/cetak', [TransaksiController::class, 'cetakStruk'])->name('admin.transaksi.cetak');

    // Profile Pribadi
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin-Only Management Features
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    // Menu
    Route::get('/menu', [MenuController::class, 'index'])->name('admin.menu.index');
    Route::post('/menu', [MenuController::class, 'store'])->name('admin.menu.store');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');

    // Laporan Keluar
    Route::get('/laporan/keluar', [LaporanKeluarController::class, 'index'])->name('admin.laporan.keluar');
    Route::post('/laporan/keluar', [LaporanKeluarController::class, 'store'])->name('admin.laporan.keluar.store');
    Route::delete('/laporan/keluar/{id}', [LaporanKeluarController::class, 'destroy'])->name('admin.laporan.keluar.destroy');

    // Kelola Salon
    Route::get('/salon/profile', [ProfileSalonController::class, 'index'])->name('admin.salon.profile');
    Route::put('/salon/profile', [ProfileSalonController::class, 'update'])->name('admin.salon.profile.update');
    Route::get('/salon/gallery', [GalleryController::class, 'index'])->name('admin.salon.gallery');
    Route::post('/salon/gallery', [GalleryController::class, 'store'])->name('admin.salon.gallery.store');
    Route::put('/salon/gallery/{id}', [GalleryController::class, 'update'])->name('admin.salon.gallery.update');
    Route::delete('/salon/gallery/{id}', [GalleryController::class, 'destroy'])->name('admin.salon.gallery.destroy');

    // Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('admin.pengguna.index');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('admin.pengguna.store');
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('admin.pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('admin.pengguna.destroy');
});
