<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangKeluar::with(['barang', 'serialNumber']);

        if ($request->filled('tanggal_awal')) {
            $query->where('tanggal_keluar', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->where('tanggal_keluar', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('barang', function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }

        $penjualanRaw = $query->orderBy('tanggal_keluar', 'desc')->get();

        $totalHPP       = $penjualanRaw->sum('hpp');
        $totalPenjualan = $penjualanRaw->sum('harga_jual');
        $totalLaba      = $penjualanRaw->sum('laba');

        // Group per nomor_transaksi + barang_id
        $penjualan = $penjualanRaw->groupBy(function ($item) {
            return $item->nomor_transaksi . '-' . $item->barang_id;
        })->map(function ($group) {
            $first          = $group->first();
            $merged         = clone $first;
            $merged->jumlah     = $group->count();
            $merged->hpp        = $group->sum('hpp');
            $merged->harga_jual = $group->sum('harga_jual');
            $merged->laba       = $group->sum('laba');
            return $merged;
        })->values();

        $barang = Barang::orderBy('nama_barang')->get();

        if ($request->export === 'pdf') {
            $pdf = Pdf::loadView('laporan.penjualan-pdf', compact('penjualan', 'totalHPP', 'totalPenjualan', 'totalLaba'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('Laporan_Penjualan_' . date('Y-m-d') . '.pdf');
        }

        if ($request->export === 'excel') {
            $filename = 'Laporan_Penjualan_' . date('Y-m-d') . '.xls';
            return response()->view('laporan.penjualan-excel', compact('penjualan', 'totalHPP', 'totalPenjualan', 'totalLaba'))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename=' . $filename)
                ->header('Cache-Control', 'max-age=0');
        }

        return view('laporan.penjualan', compact('penjualan', 'barang', 'totalHPP', 'totalPenjualan', 'totalLaba'));
    }
}
