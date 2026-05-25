<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanBukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $tanggalDari   = $request->filled('tanggal_dari')   ? $request->tanggal_dari   : date('Y-m-01');
        $tanggalSampai = $request->filled('tanggal_sampai') ? $request->tanggal_sampai : date('Y-m-d');

        $query = Akun::query()->where('is_active', true);

        if ($request->filled('tipe_akun')) {
            $query->where('tipe_akun', $request->tipe_akun);
        }

        if ($request->filled('akun_id')) {
            $query->where('id', $request->akun_id);
        }

        $akunQuery = $query->orderBy('kode_akun')->get();
        $akunList  = Akun::where('is_active', true)->orderBy('kode_akun')->get();

        $bukuBesar = [];
        foreach ($akunQuery as $akun) {
            $saldoAwal = $akun->saldo_normal ?? 0;

            if ($tanggalDari) {
                $transaksiSebelumnya = JurnalDetail::where('akun_id', $akun->id)
                    ->whereHas('jurnalEntry', fn ($q) => $q->where('tanggal', '<', $tanggalDari))
                    ->get();

                $debitSebelum  = $transaksiSebelumnya->sum('debit');
                $kreditSebelum = $transaksiSebelumnya->sum('kredit');

                $saldoAwal = $akun->posisi_normal === 'Debit'
                    ? ($akun->saldo_normal ?? 0) + $debitSebelum - $kreditSebelum
                    : ($akun->saldo_normal ?? 0) + $kreditSebelum - $debitSebelum;
            }

            $transaksi = JurnalDetail::where('akun_id', $akun->id)
                ->whereHas('jurnalEntry', function ($q) use ($tanggalDari, $tanggalSampai) {
                    $q->whereBetween('tanggal', [$tanggalDari, $tanggalSampai]);
                })
                ->with(['jurnalEntry'])
                ->orderBy('created_at', 'asc')
                ->get();

            $totalDebit      = $transaksi->sum('debit');
            $totalKredit     = $transaksi->sum('kredit');
            $jumlahTransaksi = $transaksi->count();

            if (($tanggalDari || $tanggalSampai) && $jumlahTransaksi === 0 && !$request->filled('akun_id')) {
                continue;
            }

            $saldoAkhir = $akun->posisi_normal === 'Debit'
                ? $saldoAwal + $totalDebit - $totalKredit
                : $saldoAwal + $totalKredit - $totalDebit;

            $transaksiFormatted = $transaksi->map(fn ($detail) => (object) [
                'tanggal'     => $detail->jurnalEntry->tanggal,
                'keterangan'  => $detail->keterangan ?? $detail->jurnalEntry->keterangan,
                'ref'         => $detail->jurnalEntry->no_jurnal ?? '',
                'debit'       => $detail->debit,
                'kredit'      => $detail->kredit,
            ]);

            $bukuBesar[] = [
                'akun'             => $akun,
                'saldo_awal'       => $saldoAwal,
                'transaksi'        => $transaksiFormatted,
                'total_debit'      => $totalDebit,
                'total_kredit'     => $totalKredit,
                'saldo'            => $saldoAkhir,
                'jumlah_transaksi' => $jumlahTransaksi,
            ];
        }

        $periode = Carbon::parse($tanggalDari)->format('d/m/Y') . ' - ' . Carbon::parse($tanggalSampai)->format('d/m/Y');

        if ($request->export === 'pdf') {
            $pdf = Pdf::loadView('laporan.buku-besar-pdf', compact('bukuBesar', 'tanggalDari', 'tanggalSampai', 'periode'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('Laporan_Buku_Besar_' . date('Y-m-d') . '.pdf');
        }

        if ($request->export === 'excel') {
            $filename = 'Laporan_Buku_Besar_' . date('Y-m-d') . '.xls';
            return response()->view('laporan.buku-besar-excel', compact('bukuBesar', 'tanggalDari', 'tanggalSampai', 'periode'))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename=' . $filename)
                ->header('Cache-Control', 'max-age=0');
        }

        return view('laporan.buku-besar', compact('bukuBesar', 'akunList', 'tanggalDari', 'tanggalSampai'));
    }

    public function detail(Request $request, Akun $akun)
    {
        $tanggalDari   = $request->tanggal_dari   ?? null;
        $tanggalSampai = $request->tanggal_sampai ?? null;

        $saldoAwal = $akun->saldo_normal ?? 0;

        if ($tanggalDari) {
            $transaksiSebelumnya = JurnalDetail::where('akun_id', $akun->id)
                ->whereHas('jurnalEntry', fn ($q) => $q->where('tanggal', '<', $tanggalDari))
                ->get();

            $debitSebelum  = $transaksiSebelumnya->sum('debit');
            $kreditSebelum = $transaksiSebelumnya->sum('kredit');

            $saldoAwal = $akun->posisi_normal === 'Debit'
                ? ($akun->saldo_normal ?? 0) + $debitSebelum - $kreditSebelum
                : ($akun->saldo_normal ?? 0) + $kreditSebelum - $debitSebelum;
        }

        $query = JurnalDetail::where('akun_id', $akun->id)->with(['jurnalEntry']);

        if ($request->filled('tanggal_dari')) {
            $query->whereHas('jurnalEntry', fn ($q) => $q->where('tanggal', '>=', $request->tanggal_dari));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereHas('jurnalEntry', fn ($q) => $q->where('tanggal', '<=', $request->tanggal_sampai));
        }

        $details = $query->orderBy('created_at', 'asc')->get();

        $saldo              = $saldoAwal;
        $detailsWithBalance = [];

        foreach ($details as $detail) {
            $saldo = $akun->posisi_normal === 'Debit'
                ? $saldo + $detail->debit - $detail->kredit
                : $saldo + $detail->kredit - $detail->debit;

            $detailsWithBalance[] = ['detail' => $detail, 'saldo' => $saldo];
        }

        $akun->saldo_normal = $saldoAwal;

        if ($request->export === 'pdf') {
            $pdf = Pdf::loadView('laporan.buku-besar-detail-pdf', compact('akun', 'detailsWithBalance'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('Detail_Buku_Besar_' . $akun->kode_akun . '_' . date('Y-m-d') . '.pdf');
        }

        return view('laporan.buku-besar-detail', compact('akun', 'detailsWithBalance'));
    }
}
