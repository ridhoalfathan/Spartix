<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total barang (unit dalam stok)
        $totalBarang = Barang::sum('stok');
        
        // Barang masuk bulan ini
        $barangMasukBulanIni = BarangMasuk::whereMonth('tanggal_masuk', now()->month)
            ->whereYear('tanggal_masuk', now()->year)
            ->sum('jumlah');
        
        // Barang keluar bulan ini
        $barangKeluarBulanIni = BarangKeluar::whereMonth('tanggal_keluar', now()->month)
            ->whereYear('tanggal_keluar', now()->year)
            ->count();
        
        // Stok rendah (barang dengan stok <= stok_minimum dan > 0)
        $stokRendah = Barang::whereColumn('stok', '<=', 'stok_minimum')
            ->where('stok', '>', 0)
            ->count();
        
        // Stok habis (barang dengan stok = 0)
        $stokHabis = Barang::where('stok', '<=', 0)->count();
        
        // Total nilai penjualan bulan ini
        $totalPenjualanBulanIni = BarangKeluar::whereMonth('tanggal_keluar', now()->month)
            ->whereYear('tanggal_keluar', now()->year)
            ->sum('harga_jual');
        
        // Total laba bulan ini
        $totalLabaBulanIni = BarangKeluar::whereMonth('tanggal_keluar', now()->month)
            ->whereYear('tanggal_keluar', now()->year)
            ->sum('laba');
        
        // Barang dengan stok rendah untuk notifikasi (maksimal 5)
        $barangStokRendah = Barang::whereColumn('stok', '<=', 'stok_minimum')
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();
        
        // Transaksi terakhir
        $transaksiTerakhir = BarangKeluar::with(['barang', 'serialNumber'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Chart data - Penjualan 7 hari terakhir
        $penjualan7Hari = BarangKeluar::select(
                DB::raw('DATE(tanggal_keluar) as tanggal'),
                DB::raw('COUNT(*) as jumlah'),
                DB::raw('SUM(harga_jual) as total')
            )
            ->where('tanggal_keluar', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();
        
        // Barang terlaris bulan ini
        $barangTerlaris = BarangKeluar::select('barang_id', DB::raw('COUNT(*) as jumlah'))
            ->whereMonth('tanggal_keluar', now()->month)
            ->whereYear('tanggal_keluar', now()->year)
            ->groupBy('barang_id')
            ->orderBy('jumlah', 'desc')
            ->with('barang')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalBarang',
            'barangMasukBulanIni',
            'barangKeluarBulanIni',
            'stokRendah',
            'stokHabis',
            'totalPenjualanBulanIni',
            'totalLabaBulanIni',
            'barangStokRendah',
            'transaksiTerakhir',
            'penjualan7Hari',
            'barangTerlaris'
        ));
    }
}