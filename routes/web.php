<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\SalaryReportController;
use App\Http\Controllers\JurnalUmumController;
use App\Http\Controllers\BukuBesarController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Protected Routes (Must Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('product', ProductController::class);

    // Operasional
    Route::resource('pembelian', PembelianController::class);
    Route::resource('pesanan', PesananController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('produksi', ProduksiController::class);

    /*
    |--------------------------------------------------------------------------
    | Salary Report
    |--------------------------------------------------------------------------
    */
    Route::resource('salary-report', SalaryReportController::class);
    Route::get('/salary-report-export-pdf', [SalaryReportController::class, 'exportPdf'])
        ->name('salary-report.export-pdf');
    Route::get('/get-karyawan/{id}', [SalaryReportController::class, 'getKaryawan'])
        ->name('get-karyawan');
    Route::patch('/salary-report/{id}/mark-paid', [SalaryReportController::class, 'markPaid'])
        ->name('salary-report.mark-paid');

    /*
    |--------------------------------------------------------------------------
    | Jurnal Umum
    |--------------------------------------------------------------------------
    */
    Route::prefix('jurnal-umum')->name('jurnal-umum.')->group(function () {
        Route::get('/', [JurnalUmumController::class, 'index'])->name('index');
        Route::get('/create', [JurnalUmumController::class, 'create'])->name('create');
        Route::post('/', [JurnalUmumController::class, 'store'])->name('store');
        Route::get('/{jurnalUmum}', [JurnalUmumController::class, 'show'])->name('show');
        Route::get('/{jurnalUmum}/edit', [JurnalUmumController::class, 'edit'])->name('edit');
        Route::put('/{jurnalUmum}', [JurnalUmumController::class, 'update'])->name('update');
        Route::delete('/{jurnalUmum}', [JurnalUmumController::class, 'destroy'])->name('destroy');

        // Sync & Export
        Route::post('/sync', [JurnalUmumController::class, 'sync'])->name('sync');
        Route::get('/export/pdf', [JurnalUmumController::class, 'exportPdf'])->name('export-pdf');
    });

    /*
    |--------------------------------------------------------------------------
    | Buku Besar
    |--------------------------------------------------------------------------
    */
    Route::prefix('buku-besar')->name('buku-besar.')->group(function () {
        Route::get('/', [BukuBesarController::class, 'index'])->name('index');
        Route::post('/sync', [BukuBesarController::class, 'sync'])->name('sync');
        Route::get('/export-pdf', [BukuBesarController::class, 'exportPdf'])->name('export-pdf');
    });

    /*
    |--------------------------------------------------------------------------
    | User Settings
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/profile', [SettingsController::class, 'updateProfile'])->name('update-profile');
        Route::post('/password', [SettingsController::class, 'updatePassword'])->name('update-password');
    });
});
