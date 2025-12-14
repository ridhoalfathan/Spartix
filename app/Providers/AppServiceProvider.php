<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pembelian;
use App\Models\Transaksi;
use App\Models\SalaryReport;
use App\Observers\PembelianObserver;
use App\Observers\TransaksiObserver;
use App\Observers\SalaryReportObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Observers untuk auto-generate jurnal
        Pembelian::observe(PembelianObserver::class);
        Transaksi::observe(TransaksiObserver::class);
        SalaryReport::observe(SalaryReportObserver::class);
    }
}