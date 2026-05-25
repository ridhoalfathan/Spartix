<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\JurnalEntry;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanJurnalUmumController extends Controller
{
    public function index(Request $request)
    {
        $tanggalDari   = $request->filled('tanggal_dari')   ? $request->tanggal_dari   : date('Y-m-01');
        $tanggalSampai = $request->filled('tanggal_sampai') ? $request->tanggal_sampai : date('Y-m-d');

        $query = JurnalEntry::with(['details.akun', 'user'])
            ->whereBetween('tanggal', [$tanggalDari, $tanggalSampai]);

        if ($request->filled('no_jurnal')) {
            $query->where('no_jurnal', 'like', '%' . $request->no_jurnal . '%');
        }

        if ($request->export === 'pdf') {
            $jurnalEntries = $query->orderBy('tanggal', 'desc')->orderBy('no_jurnal', 'desc')->get();
            $pdf = Pdf::loadView('laporan.jurnal-umum-pdf', compact('jurnalEntries', 'tanggalDari', 'tanggalSampai'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('Laporan_Jurnal_Umum_' . date('Y-m-d') . '.pdf');
        }

        if ($request->export === 'excel') {
            $jurnalEntries = $query->orderBy('tanggal', 'desc')->orderBy('no_jurnal', 'desc')->get();
            $filename = 'Laporan_Jurnal_Umum_' . date('Y-m-d') . '.xls';
            return response()->view('laporan.jurnal-umum-excel', compact('jurnalEntries', 'tanggalDari', 'tanggalSampai'))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename=' . $filename)
                ->header('Cache-Control', 'max-age=0');
        }

        $jurnalEntries = $query->orderBy('tanggal', 'desc')->orderBy('no_jurnal', 'desc')->paginate(20);

        return view('laporan.jurnal-umum', compact('jurnalEntries', 'tanggalDari', 'tanggalSampai'));
    }
}
