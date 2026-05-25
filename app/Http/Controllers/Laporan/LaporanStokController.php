<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanStokController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'habis':
                    $query->where('stok', '<=', 0);
                    break;
                case 'rendah':
                    $query->whereColumn('stok', '<=', 'stok_minimum')
                          ->where('stok', '>', 0);
                    break;
                case 'normal':
                    $query->whereColumn('stok', '>', 'stok_minimum');
                    break;
            }
        }

        $barang = $query->with(['serialNumbers' => function ($q) {
            $q->where('status', 'READY');
        }])->orderBy('nama_barang')->get();

        if ($request->export === 'pdf') {
            $pdf = Pdf::loadView('laporan.stok-pdf', compact('barang'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('Laporan_Stok_' . date('Y-m-d') . '.pdf');
        }

        if ($request->export === 'excel') {
            $filename = 'Laporan_Stok_' . date('Y-m-d') . '.xls';
            return response()->view('laporan.stok-excel', compact('barang'))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename=' . $filename)
                ->header('Cache-Control', 'max-age=0');
        }

        return view('laporan.stok', compact('barang'));
    }
}
