<?php

namespace App\Http\Controllers;

use App\Models\JurnalUmum;
use App\Services\JurnalUmumService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class JurnalUmumController extends Controller
{
    protected $jurnalService;

    public function __construct(JurnalUmumService $jurnalService)
    {
        $this->jurnalService = $jurnalService;
    }

    /**
     * Daftar akun standar untuk dropdown
     */
    private function getAkunList()
    {
        return [
            'Aset' => [
                'Kas' => 'Kas',
                'Bank' => 'Bank',
                'Piutang Usaha' => 'Piutang Usaha',
                'Piutang Dagang' => 'Piutang Dagang',
                'Persediaan Barang' => 'Persediaan Barang',
                'Perlengkapan' => 'Perlengkapan',
                'Sewa Dibayar Dimuka' => 'Sewa Dibayar Dimuka',
                'Asuransi Dibayar Dimuka' => 'Asuransi Dibayar Dimuka',
                'Peralatan' => 'Peralatan',
                'Akumulasi Penyusutan Peralatan' => 'Akumulasi Penyusutan Peralatan',
                'Kendaraan' => 'Kendaraan',
                'Akumulasi Penyusutan Kendaraan' => 'Akumulasi Penyusutan Kendaraan',
                'Gedung' => 'Gedung',
                'Akumulasi Penyusutan Gedung' => 'Akumulasi Penyusutan Gedung',
                'Tanah' => 'Tanah',
            ],
            'Liabilitas' => [
                'Utang Usaha' => 'Utang Usaha',
                'Utang Dagang' => 'Utang Dagang',
                'Utang Gaji' => 'Utang Gaji',
                'Utang Bank' => 'Utang Bank',
                'Utang Pajak' => 'Utang Pajak',
                'Pendapatan Diterima Dimuka' => 'Pendapatan Diterima Dimuka',
                'Utang Jangka Panjang' => 'Utang Jangka Panjang',
            ],
            'Ekuitas' => [
                'Modal' => 'Modal',
                'Modal Pemilik' => 'Modal Pemilik',
                'Prive' => 'Prive',
                'Laba Ditahan' => 'Laba Ditahan',
                'Laba Tahun Berjalan' => 'Laba Tahun Berjalan',
            ],
            'Pendapatan' => [
                'Pendapatan Jasa' => 'Pendapatan Jasa',
                'Pendapatan Usaha' => 'Pendapatan Usaha',
                'Pendapatan Penjualan' => 'Pendapatan Penjualan',
                'Pendapatan Bunga' => 'Pendapatan Bunga',
                'Pendapatan Lain-lain' => 'Pendapatan Lain-lain',
            ],
            'Beban' => [
                'Pembelian' => 'Pembelian',
                'Beban Gaji' => 'Beban Gaji',
                'Beban Listrik' => 'Beban Listrik',
                'Beban Air' => 'Beban Air',
                'Beban Telepon' => 'Beban Telepon',
                'Beban Sewa' => 'Beban Sewa',
                'Beban Perlengkapan' => 'Beban Perlengkapan',
                'Beban Penyusutan Peralatan' => 'Beban Penyusutan Peralatan',
                'Beban Penyusutan Kendaraan' => 'Beban Penyusutan Kendaraan',
                'Beban Penyusutan Gedung' => 'Beban Penyusutan Gedung',
                'Beban Transportasi' => 'Beban Transportasi',
                'Beban Administrasi' => 'Beban Administrasi',
                'Beban Pemeliharaan' => 'Beban Pemeliharaan',
                'Beban Iklan' => 'Beban Iklan',
                'Beban Pajak' => 'Beban Pajak',
                'Beban Bunga' => 'Beban Bunga',
                'Beban Lain-lain' => 'Beban Lain-lain',
            ],
        ];
    }

    public function index(Request $request)
    {
        $query = JurnalUmum::query();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sumber = $request->input('sumber');

        // Filter by date range
        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        // Filter by sumber
        if ($sumber && $sumber !== 'semua') {
            $query->where('sumber_transaksi', $sumber);
        }

        $jurnals = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalDebit = $jurnals->sum('debit');
        $totalKredit = $jurnals->sum('kredit');

        return view('jurnal-umum.index', compact(
            'jurnals', 
            'totalDebit', 
            'totalKredit', 
            'startDate', 
            'endDate',
            'sumber'
        ));
    }

    /**
     * Sync data otomatis dari pembelian, transaksi, salary
     */
    public function sync()
    {
        try {
            $result = $this->jurnalService->syncAll();
            
            return redirect()->route('jurnal-umum.index')
                ->with('success', "Berhasil sinkronisasi {$result['total']} jurnal! (Pembelian: {$result['pembelian']}, Transaksi: {$result['transaksi']}, Gaji: {$result['salary']})");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal sinkronisasi: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $akuns = $this->getAkunList();
        return view('jurnal-umum.create', compact('akuns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:500',
            'akun_debit' => 'required|string|max:100',
            'debit' => 'required|numeric|min:0',
            'akun_kredit' => 'required|string|max:100',
            'kredit' => 'required|numeric|min:0',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'keterangan.required' => 'Keterangan harus diisi',
            'akun_debit.required' => 'Akun debit harus dipilih',
            'debit.required' => 'Nominal debit harus diisi',
            'debit.min' => 'Nominal debit tidak boleh negatif',
            'akun_kredit.required' => 'Akun kredit harus dipilih',
            'kredit.required' => 'Nominal kredit harus diisi',
            'kredit.min' => 'Nominal kredit tidak boleh negatif',
        ]);

        // Validasi: Debit dan Kredit harus seimbang
        if ($validated['debit'] != $validated['kredit']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nominal Debit dan Kredit harus seimbang! Debit: Rp ' . number_format($validated['debit'], 0, ',', '.') . ' | Kredit: Rp ' . number_format($validated['kredit'], 0, ',', '.'));
        }

        // Validasi: Akun Debit dan Kredit tidak boleh sama
        if ($validated['akun_debit'] == $validated['akun_kredit']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akun Debit dan Kredit tidak boleh sama!');
        }

        DB::beginTransaction();
        try {
            // Manual entry
            $validated['sumber_transaksi'] = 'manual';
            JurnalUmum::create($validated);

            DB::commit();
            return redirect()->route('jurnal-umum.index')
                ->with('success', 'Jurnal umum berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(JurnalUmum $jurnalUmum)
    {
        return view('jurnal-umum.show', compact('jurnalUmum'));
    }

    public function edit(JurnalUmum $jurnalUmum)
    {
        // Hanya jurnal manual yang bisa diedit
        if (!$jurnalUmum->isManual()) {
            return redirect()->route('jurnal-umum.index')
                ->with('error', 'Jurnal otomatis tidak dapat diedit! Silakan edit data sumber (Pembelian/Transaksi/Gaji)');
        }

        $jurnal = $jurnalUmum;
        $akuns = $this->getAkunList();
        return view('jurnal-umum.edit', compact('jurnal', 'akuns'));
    }

    public function update(Request $request, JurnalUmum $jurnalUmum)
    {
        // Hanya jurnal manual yang bisa diupdate
        if (!$jurnalUmum->isManual()) {
            return redirect()->route('jurnal-umum.index')
                ->with('error', 'Jurnal otomatis tidak dapat diedit! Silakan edit data sumber (Pembelian/Transaksi/Gaji)');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:500',
            'akun_debit' => 'required|string|max:100',
            'debit' => 'required|numeric|min:0',
            'akun_kredit' => 'required|string|max:100',
            'kredit' => 'required|numeric|min:0',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'keterangan.required' => 'Keterangan harus diisi',
            'akun_debit.required' => 'Akun debit harus dipilih',
            'debit.required' => 'Nominal debit harus diisi',
            'debit.min' => 'Nominal debit tidak boleh negatif',
            'akun_kredit.required' => 'Akun kredit harus dipilih',
            'kredit.required' => 'Nominal kredit harus diisi',
            'kredit.min' => 'Nominal kredit tidak boleh negatif',
        ]);

        // Validasi: Debit dan Kredit harus seimbang
        if ($validated['debit'] != $validated['kredit']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nominal Debit dan Kredit harus seimbang!');
        }

        // Validasi: Akun Debit dan Kredit tidak boleh sama
        if ($validated['akun_debit'] == $validated['akun_kredit']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akun Debit dan Kredit tidak boleh sama!');
        }

        DB::beginTransaction();
        try {
            $jurnalUmum->update($validated);

            DB::commit();
            return redirect()->route('jurnal-umum.index')
                ->with('success', 'Jurnal umum berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(JurnalUmum $jurnalUmum)
    {
        // Hanya jurnal manual yang bisa dihapus
        if (!$jurnalUmum->isManual()) {
            return redirect()->route('jurnal-umum.index')
                ->with('error', 'Jurnal otomatis tidak dapat dihapus! Silakan hapus data sumber (Pembelian/Transaksi/Gaji)');
        }

        DB::beginTransaction();
        try {
            $jurnalUmum->delete();

            DB::commit();
            return redirect()->route('jurnal-umum.index')
                ->with('success', 'Jurnal umum berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $query = JurnalUmum::query();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sumber = $request->input('sumber');

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        if ($sumber && $sumber !== 'semua') {
            $query->where('sumber_transaksi', $sumber);
        }

        $jurnals = $query->orderBy('tanggal', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
            
        $totalDebit = $jurnals->sum('debit');
        $totalKredit = $jurnals->sum('kredit');

        $pdf = PDF::loadView('jurnal-umum.pdf', compact(
            'jurnals', 
            'totalDebit', 
            'totalKredit', 
            'startDate', 
            'endDate',
            'sumber'
        ));
        
        return $pdf->download('jurnal-umum-' . date('Y-m-d') . '.pdf');
    }
}