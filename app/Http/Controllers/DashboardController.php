<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Product;
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

        // Statistik per kategori karyawan
        $karyawanStats = Karyawan::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();

        // Statistik per jabatan
        $jabatanStats = Karyawan::select('jabatan', DB::raw('count(*) as total'))
            ->groupBy('jabatan')
            ->get();

        return view('dashboard', compact(
            'stats',
            'salesData',
            'topProducts',
            'recentKaryawan',
            'lowStockProducts',
            'karyawanStats',
            'jabatanStats'
        ));
    }

    // Helper method untuk total penjualan (dummy data, sesuaikan dengan tabel transaksi Anda)
    private function getTotalPenjualan()
    {
        // Jika ada tabel transaksi, gunakan:
        // return DB::table('transaksi')->sum('total');
        
        // Untuk sekarang return dummy data
        return 'Rp ' . number_format(45250000, 0, ',', '.');
    }

    // Helper method untuk total order (dummy data)
    private function getTotalOrder()
    {
        // Jika ada tabel order, gunakan:
        // return DB::table('orders')->count();
        
        return 247;
    }

    // Helper method untuk data chart penjualan
    private function getSalesChartData()
    {
        // Jika ada tabel transaksi, ambil data per bulan:
        /*
        $salesByMonth = DB::table('transaksi')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();
        */

        // Untuk sekarang return dummy data
        return [
            'labels' => ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun"],
            'data' => [650, 800, 560, 900, 750, 950]
        ];
    }
}