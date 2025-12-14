<?php

namespace App\Http\Controllers;

use App\Models\BukuBesar;
use App\Models\JurnalUmum;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BukuBesarController extends Controller
{
    // Definisikan posisi normal akun
    private function isAkunDebitNormal($namaAkun)
    {
        // Akun dengan posisi normal di DEBIT (Aset & Beban)
        $akunDebit = [
            'Kas', 
            'Bank',
            'Piutang', 
            'Piutang Usaha',
            'Perlengkapan', 
            'Peralatan',
            'Persediaan',
            'Aktiva Tetap',
            'Beban Gaji', 
            'Beban Sewa', 
            'Beban Listrik',
            'Beban Air',
            'Beban Telepon',
            'Beban Lain-lain',
            'Pembelian',
            'Retur Penjualan',
            'Potongan Penjualan'
        ];
        
        // Cek apakah nama akun mengandung kata-kata beban
        foreach ($akunDebit as $akun) {
            if (stripos($namaAkun, $akun) !== false) {
                return true;
            }
        }
        
        // Cek jika mengandung kata "Beban"
        if (stripos($namaAkun, 'Beban') !== false) {
            return true;
        }
        
        return false;
    }

    public function index(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        $akunFilter = $request->akun;

        // Daftar akun dari database
        $daftarAkun = BukuBesar::select('nama_akun')
            ->distinct()
            ->orderBy('nama_akun')
            ->pluck('nama_akun');

        // Query buku besar
        $query = BukuBesar::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('nama_akun')
            ->orderBy('tanggal')
            ->orderBy('id');

        if ($akunFilter) {
            $query->where('nama_akun', $akunFilter);
        }

        $bukuBesar = $query->get();
        $bukuBesarGrouped = $bukuBesar->groupBy('nama_akun');

        // Hitung saldo awal per akun
        $saldoAwal = [];
        foreach ($daftarAkun as $akun) {
            $saldoSebelumnya = BukuBesar::where('nama_akun', $akun)
                ->where('tanggal', '<', $startDate)
                ->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc')
                ->first();
            
            $saldoAwal[$akun] = $saldoSebelumnya ? $saldoSebelumnya->saldo : 0;
        }

        return view('buku-besar.index', compact(
            'bukuBesarGrouped',
            'daftarAkun',
            'startDate',
            'endDate',
            'akunFilter',
            'saldoAwal'
        ));
    }

    public function sync()
    {
        try {
            // Hapus semua data buku besar
            BukuBesar::truncate();

            // Ambil semua jurnal umum, urutkan by tanggal dan id
            $jurnals = JurnalUmum::orderBy('tanggal')->orderBy('id')->get();

            // Array untuk menyimpan saldo tiap akun
            $saldoAkun = [];

            foreach ($jurnals as $jurnal) {
                $akunDebit = $jurnal->akun_debit;
                $akunKredit = $jurnal->akun_kredit;

                // Inisialisasi saldo jika belum ada
                if (!isset($saldoAkun[$akunDebit])) {
                    $saldoAkun[$akunDebit] = 0;
                }
                if (!isset($saldoAkun[$akunKredit])) {
                    $saldoAkun[$akunKredit] = 0;
                }

                // === PROSES DEBIT ===
                // Cek posisi normal akun debit
                if ($this->isAkunDebitNormal($akunDebit)) {
                    // Akun posisi normal DEBIT: Debit (+), Kredit (-)
                    $saldoAkun[$akunDebit] += $jurnal->debit;
                } else {
                    // Akun posisi normal KREDIT: Debit (-), Kredit (+)
                    $saldoAkun[$akunDebit] -= $jurnal->debit;
                }

                // Simpan baris debit
                BukuBesar::create([
                    'jurnal_umum_id' => $jurnal->id,
                    'nama_akun' => $akunDebit,
                    'tanggal' => $jurnal->tanggal,
                    'keterangan' => $jurnal->keterangan,
                    'no_referensi' => $jurnal->no_referensi,
                    'debit' => $jurnal->debit,
                    'kredit' => 0,
                    'saldo' => $saldoAkun[$akunDebit]
                ]);

                // === PROSES KREDIT ===
                // Cek posisi normal akun kredit
                if ($this->isAkunDebitNormal($akunKredit)) {
                    // Akun posisi normal DEBIT: Debit (+), Kredit (-)
                    $saldoAkun[$akunKredit] -= $jurnal->kredit;
                } else {
                    // Akun posisi normal KREDIT: Debit (-), Kredit (+)
                    $saldoAkun[$akunKredit] += $jurnal->kredit;
                }

                // Simpan baris kredit
                BukuBesar::create([
                    'jurnal_umum_id' => $jurnal->id,
                    'nama_akun' => $akunKredit,
                    'tanggal' => $jurnal->tanggal,
                    'keterangan' => $jurnal->keterangan,
                    'no_referensi' => $jurnal->no_referensi,
                    'debit' => 0,
                    'kredit' => $jurnal->kredit,
                    'saldo' => $saldoAkun[$akunKredit]
                ]);
            }

            return redirect()->route('buku-besar.index')
                ->with('success', 'Buku Besar berhasil disinkronisasi! Total ' . $jurnals->count() . ' transaksi jurnal diproses.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal sinkronisasi: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        $akunFilter = $request->akun;

        $query = BukuBesar::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('nama_akun')
            ->orderBy('tanggal')
            ->orderBy('id');

        if ($akunFilter) {
            $query->where('nama_akun', $akunFilter);
        }

        $bukuBesar = $query->get();
        $bukuBesarGrouped = $bukuBesar->groupBy('nama_akun');

        // Daftar akun dari database
        $daftarAkun = BukuBesar::select('nama_akun')
            ->distinct()
            ->orderBy('nama_akun')
            ->pluck('nama_akun');

        $saldoAwal = [];
        foreach ($daftarAkun as $akun) {
            $saldoSebelumnya = BukuBesar::where('nama_akun', $akun)
                ->where('tanggal', '<', $startDate)
                ->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc')
                ->first();
            
            $saldoAwal[$akun] = $saldoSebelumnya ? $saldoSebelumnya->saldo : 0;
        }

        $pdf = PDF::loadView('buku-besar.pdf', compact(
            'bukuBesarGrouped',
            'startDate',
            'endDate',
            'akunFilter',
            'saldoAwal'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('Buku-Besar-' . $startDate . '-sd-' . $endDate . '.pdf');
    }
}