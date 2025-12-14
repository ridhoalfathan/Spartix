<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Product;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Cards
        $stats = [
            'total_penjualan' => $this->getTotalPenjualan(),
            'stock_products' => Product::sum('stock'),
            'total_order' => $this->getTotalOrder(),
            'total_karyawan' => Karyawan::count(),
            'total_products' => Product::count(),
        ];

        // Data untuk chart penjualan
        $salesData = $this->getSalesChartData();

        // Top Products berdasarkan stock terbanyak
        $topProducts = Product::orderBy('stock', 'desc')
            ->take(5)
            ->get();

        // Karyawan terbaru
        $recentKaryawan = Karyawan::latest()
            ->take(5)
            ->get();

        // Stock products yang rendah (< 100)
        $lowStockProducts = Product::where('stock', '<', 100)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Karyawan berdasarkan Jabatan
        $karyawanByJabatan = Karyawan::select('jabatan', DB::raw('count(*) as total'))
            ->groupBy('jabatan')
            ->get();

        return view('dashboard', compact(
            'stats',
            'salesData',
            'topProducts',
            'recentKaryawan',
            'lowStockProducts',
            'karyawanByJabatan'
        ));
    }

    // Total penjualan dari Transaksi yang Success
    private function getTotalPenjualan()
    {
        $total = Transaksi::where('status', 'Success')->sum('total_transaksi');
        return 'Rp ' . number_format($total, 0, ',', '.');
    }

    // Total order dari Pesanan
    private function getTotalOrder()
    {
        return Pesanan::count();
    }

    // Data chart penjualan dari Pesanan yang Complete (6 bulan terakhir)
    private function getSalesChartData()
    {
        // Ambil data pesanan complete 6 bulan terakhir
        $sixMonthsAgo = now()->subMonths(6)->startOfMonth();
        
        $pesananComplete = Pesanan::where('status', 'Complete')
            ->where('tanggal_pembayaran', '>=', $sixMonthsAgo)
            ->select(
                DB::raw('DATE_FORMAT(tanggal_pembayaran, "%Y-%m") as month'),
                DB::raw('SUM(jumlah_pesanan) as total')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Buat array untuk 6 bulan terakhir
        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $monthLabel = $month->format('M Y');
            
            $labels[] = $monthLabel;
            
            // Cari data untuk bulan ini
            $monthData = $pesananComplete->firstWhere('month', $monthKey);
            
            // Tampilkan total jumlah pesanan
            $data[] = $monthData ? $monthData->total : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}