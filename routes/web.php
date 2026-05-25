<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\SerialNumberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Laporan\LaporanStokController;
use App\Http\Controllers\Laporan\LaporanKartuStokController;
use App\Http\Controllers\Laporan\LaporanPenjualanController;
use App\Http\Controllers\Laporan\LaporanJurnalUmumController;
use App\Http\Controllers\Laporan\LaporanBukuBesarController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ==========================================
    // ROUTE KHUSUS ADMIN
    // ==========================================
    Route::middleware(\App\Http\Middleware\CheckRole::class.':admin')->group(function () {
        // Master Data - Barang
        Route::resource('barang', BarangController::class);

        // Master Akuntansi - Akun
        Route::resource('akun', AkunController::class);

        // Transaksi - Barang Masuk
        Route::resource('barang-masuk', BarangMasukController::class)
            ->except(['edit', 'update']);

        // Transaksi - Barang Keluar
        Route::resource('barang-keluar', BarangKeluarController::class)
            ->except(['edit', 'update']);
        Route::get('/barang-keluar/invoice/{nomorTransaksi}', [BarangKeluarController::class, 'invoice'])
            ->name('barang-keluar.invoice');
        Route::get('/get-barang-detail', [BarangKeluarController::class, 'getBarangDetail'])
            ->name('barang-keluar.get-barang-detail');
        
        // Ajax route untuk get serial numbers
        Route::get('/get-serial-numbers', [BarangKeluarController::class, 'getSerialNumbers'])
            ->name('get-serial-numbers');

        // Serial Numbers Management
        Route::get('/serial-numbers', [SerialNumberController::class, 'index'])
            ->name('serial-numbers.index');
        Route::get('/serial-numbers/{serialNumber}', [SerialNumberController::class, 'show'])
            ->name('serial-numbers.show');
    });

    // ==========================================
    // ROUTE BISA DIAKSES SEMUA ROLE
    // ==========================================
    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        // Laporan Inventori
        Route::get('/stok',       [LaporanStokController::class,      'index'])->name('stok');
        Route::get('/kartu-stok', [LaporanKartuStokController::class, 'index'])->name('kartu-stok');
        Route::get('/penjualan',  [LaporanPenjualanController::class, 'index'])->name('penjualan');

        // Laporan Akuntansi
        Route::get('/jurnal-umum',    [LaporanJurnalUmumController::class, 'index'])->name('jurnal-umum');
        Route::get('/buku-besar',     [LaporanBukuBesarController::class,  'index'])->name('buku-besar');
        Route::get('/buku-besar/{akun}', [LaporanBukuBesarController::class, 'detail'])->name('buku-besar.detail');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});