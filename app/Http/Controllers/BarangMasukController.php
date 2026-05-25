<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\SerialNumber;
use App\Models\JurnalEntry;
use App\Models\JurnalDetail;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('barang')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('barang-masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $barang = Barang::orderBy('nama_barang')->get();
        return view('barang-masuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'supplier' => 'nullable|string|max:255',
        ], [
            'barang_id.required' => 'Barang harus dipilih',
            'barang_id.exists' => 'Barang tidak valid',
            'jumlah.required' => 'Jumlah harus diisi',
            'jumlah.min' => 'Jumlah minimal 1',
            'harga_beli.required' => 'Harga beli harus diisi',
            'harga_beli.min' => 'Harga beli minimal 0',
            'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::findOrFail($request->barang_id);
            $tanggalMasuk = Carbon::parse($request->tanggal_masuk);
            
            // Buat transaksi barang masuk
            $totalHarga = $request->jumlah * $request->harga_beli;
            $barangMasuk = BarangMasuk::create([
                'nomor_transaksi' => BarangMasuk::generateNomorTransaksi(),
                'barang_id' => $request->barang_id,
                'jumlah' => $request->jumlah,
                'harga_beli' => $request->harga_beli,
                'total_harga' => $totalHarga,
                'tanggal_masuk' => $request->tanggal_masuk,
                'supplier' => $request->supplier,
            ]);

            // Generate serial numbers otomatis
            $generatedSerials = $this->generateSerialNumbers(
                $barang,
                $request->jumlah,
                $tanggalMasuk
            );

            // Simpan serial numbers
            foreach ($generatedSerials as $serialNumber) {
                SerialNumber::create([
                    'serial_number' => $serialNumber,
                    'barang_id' => $request->barang_id,
                    'barang_masuk_id' => $barangMasuk->id,
                    'harga_beli' => $request->harga_beli,
                    'status' => 'READY',
                    'tanggal_masuk' => $request->tanggal_masuk,
                ]);
            }

            // Update stok barang
            $barang->increment('stok', $request->jumlah);

            // ✨ BUAT JURNAL OTOMATIS - PEMBELIAN
            $this->createJurnalPembelian($barangMasuk, $barang);

            DB::commit();

            return redirect()->route('barang-masuk.index')
                ->with('success', 'Barang masuk berhasil ditambahkan dengan ' . count($generatedSerials) . ' serial number dan jurnal tercatat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * 🆕 Buat Jurnal Otomatis untuk Pembelian Barang
     */
    private function createJurnalPembelian($barangMasuk, $barang)
    {
        $totalHarga = $barangMasuk->total_harga;

        // Generate Nomor Jurnal
        $noJurnal = JurnalEntry::generateNoJurnal();

        // Buat Jurnal Entry
        $jurnalEntry = JurnalEntry::create([
            'no_jurnal' => $noJurnal,
            'tanggal' => $barangMasuk->tanggal_masuk,
            'referensi' => $barangMasuk->id,
            'referensi_type' => 'BarangMasuk',
            'keterangan' => "Pembelian {$barangMasuk->jumlah} unit {$barang->nama_barang}" . 
                           ($barangMasuk->supplier ? " dari {$barangMasuk->supplier}" : ""),
            'user_id' => auth()->id()
        ]);

        // DEBIT: Persediaan Barang (Aset bertambah)
        JurnalDetail::create([
            'jurnal_entry_id' => $jurnalEntry->id,
            'akun_id' => $this->getAkunId('1201'), // Persediaan Barang
            'debit' => $totalHarga,
            'kredit' => 0,
            'keterangan' => "Pembelian {$barangMasuk->jumlah} unit {$barang->nama_barang} @ Rp " . number_format($barangMasuk->harga_beli, 0, ',', '.')
        ]);

        // KREDIT: Kas (Aset berkurang - uang keluar)
        JurnalDetail::create([
            'jurnal_entry_id' => $jurnalEntry->id,
            'akun_id' => $this->getAkunId('1101'), // Kas
            'debit' => 0,
            'kredit' => $totalHarga,
            'keterangan' => "Pembayaran pembelian" . ($barangMasuk->supplier ? " kepada {$barangMasuk->supplier}" : "")
        ]);
    }

    /**
     * Helper untuk get Akun ID berdasarkan kode akun
     */
    private function getAkunId($kodeAkun)
    {
        $akun = Akun::where('kode_akun', $kodeAkun)->first();
        
        if (!$akun) {
            throw new \Exception("Akun dengan kode {$kodeAkun} tidak ditemukan. Silakan tambahkan akun terlebih dahulu di menu Akun.");
        }
        
        return $akun->id;
    }

    /**
     * Generate serial numbers otomatis
     * Format: {PREFIX_KATEGORI}{TAHUN}{BULAN}{TANGGAL}-{URUTAN}
     * Contoh: TV250107-0001, AC250107-0002, KL250107-0003
     */
    private function generateSerialNumbers($barang, $jumlah, $tanggalMasuk)
    {
        $serialNumbers = [];
        
        // Buat prefix dari kategori (3 huruf pertama uppercase)
        $prefix = strtoupper(substr($barang->kategori, 0, 3));
        
        // Format tanggal: YY MM DD (contoh: 250107 untuk 07 Jan 2025)
        $dateCode = $tanggalMasuk->format('ymd');
        
        // Gabungkan prefix
        $baseCode = $prefix . $dateCode;
        
        // Cari serial number terakhir dengan prefix yang sama pada tanggal yang sama
        $lastSerial = SerialNumber::where('serial_number', 'LIKE', $baseCode . '-%')
            ->orderBy('serial_number', 'desc')
            ->first();
        
        // Tentukan nomor urut awal
        if ($lastSerial) {
            // Ambil 4 digit terakhir dari serial number terakhir
            $lastNumber = intval(substr($lastSerial->serial_number, -4));
            $startNumber = $lastNumber + 1;
        } else {
            $startNumber = 1;
        }
        
        // Generate serial numbers sejumlah yang diminta
        for ($i = 0; $i < $jumlah; $i++) {
            $currentNumber = $startNumber + $i;
            $serialNumbers[] = $baseCode . '-' . str_pad($currentNumber, 4, '0', STR_PAD_LEFT);
        }
        
        return $serialNumbers;
    }

    public function show(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load(['barang', 'serialNumbers']);
        return view('barang-masuk.show', compact('barangMasuk'));
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        // Cek apakah ada serial number yang sudah terjual
        $terjual = $barangMasuk->serialNumbers()->where('status', 'TERJUAL')->count();
        
        if ($terjual > 0) {
            return redirect()->route('barang-masuk.index')
                ->with('error', 'Tidak dapat menghapus transaksi karena ada barang yang sudah terjual');
        }

        DB::beginTransaction();
        try {
            // Update stok barang
            $barang = $barangMasuk->barang;
            $barang->decrement('stok', $barangMasuk->jumlah);

            // Hapus serial numbers
            $barangMasuk->serialNumbers()->delete();

            // 🆕 Hapus jurnal terkait
            JurnalEntry::where('referensi', $barangMasuk->id)
                ->where('referensi_type', 'BarangMasuk')
                ->delete();

            // Hapus transaksi
            $barangMasuk->delete();

            DB::commit();

            return redirect()->route('barang-masuk.index')
                ->with('success', 'Transaksi barang masuk dan jurnal berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('barang-masuk.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

