<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\SerialNumber;
use App\Models\JurnalEntry;
use App\Models\JurnalDetail;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with(['barang', 'serialNumber'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('barang-keluar.index', compact('barangKeluar'));
    }

    public function create()
    {
        $barang = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();
        return view('barang-keluar.create', compact('barang'));
    }

    public function getSerialNumbers(Request $request)
    {
        $serialNumbers = SerialNumber::where('barang_id', $request->barang_id)
            ->where('status', 'READY')
            ->orderBy('tanggal_masuk', 'asc') // FIFO
            ->get();
        
        return response()->json($serialNumbers);
    }

    public function getBarangDetail(Request $request)
    {
        $barang = Barang::find($request->barang_id);
        
        if ($barang) {
            return response()->json([
                'success' => true,
                'harga' => $barang->harga,
                'stok' => $barang->stok
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Barang tidak ditemukan'
        ], 404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga_jual' => 'required|numeric|min:0',
            'tanggal_keluar' => 'required|date',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'customer' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $nomorTransaksi = BarangKeluar::generateNomorTransaksi();
            $errors = [];
            $totalPenjualan = 0;
            $totalHPP = 0;
            $barangDetails = [];

            foreach ($request->items as $index => $item) {
                // Ambil barang
                $barang = Barang::find($item['barang_id']);
                
                // Ambil serial number sebanyak qty (FIFO)
                $serialNumbers = SerialNumber::where('barang_id', $item['barang_id'])
                    ->where('status', 'READY')
                    ->orderBy('tanggal_masuk', 'asc')
                    ->take($item['qty'])
                    ->lockForUpdate() // mencegah race condition
                    ->get();
                
                if ($serialNumbers->count() < $item['qty']) {
                    $errors[] = "Item #" . ($index + 1) . ": Stok {$barang->nama_barang} tidak mencukupi. (Tersedia: {$serialNumbers->count()})";
                    continue;
                }

                foreach ($serialNumbers as $serialNumber) {
                    // Hitung HPP dan Laba
                    $hpp = $serialNumber->harga_beli;
                    
                    if ($item['harga_jual'] < $hpp) {
                        $errors[] = "Item #" . ($index + 1) . ": Harga jual tidak boleh lebih kecil dari Harga Beli/HPP (Rp " . number_format($hpp, 0, ',', '.') . ") untuk Serial Number {$serialNumber->serial_number}";
                        continue;
                    }
                    
                    $laba = $item['harga_jual'] - $hpp;

                    // Buat transaksi barang keluar
                    BarangKeluar::create([
                        'nomor_transaksi' => $nomorTransaksi,
                        'barang_id' => $item['barang_id'],
                        'serial_number_id' => $serialNumber->id,
                        'hpp' => $hpp,
                        'harga_jual' => $item['harga_jual'],
                        'laba' => $laba,
                        'tanggal_keluar' => $request->tanggal_keluar,
                        'metode_pembayaran' => $request->metode_pembayaran,
                        'customer' => $request->customer,
                    ]);

                    // Update serial number status
                    $serialNumber->update([
                        'status' => 'TERJUAL',
                        'tanggal_keluar' => $request->tanggal_keluar,
                    ]);

                    // Kumpulkan data untuk jurnal
                    $totalPenjualan += $item['harga_jual'];
                    $totalHPP += $hpp;
                }

                // Update stok barang
                $barang->decrement('stok', $item['qty']);
                
                if (!isset($barangDetails[$item['barang_id']])) {
                    $barangDetails[$item['barang_id']] = [
                        'nama' => $barang->nama_barang,
                        'jumlah' => 0,
                        'total_jual' => 0,
                        'total_hpp' => 0
                    ];
                }
                $barangDetails[$item['barang_id']]['jumlah'] += $item['qty'];
                $barangDetails[$item['barang_id']]['total_jual'] += ($item['harga_jual'] * $item['qty']);
                // total_hpp already added in the loop above? No, we should add it per serial number... wait.
                // It is better to just calculate total_hpp for this item block:
                $itemTotalHpp = $serialNumbers->sum('harga_beli');
                $barangDetails[$item['barang_id']]['total_hpp'] += $itemTotalHpp;
            }

            if (!empty($errors)) {
                DB::rollback();
                return back()->withErrors(['items' => $errors])->withInput();
            }

            // ✨ BUAT JURNAL OTOMATIS - PENJUALAN (hanya sekali untuk semua item)
            $this->createJurnalPenjualan(
                $nomorTransaksi,
                $request->tanggal_keluar,
                $request->customer,
                $totalPenjualan,
                $totalHPP,
                $barangDetails,
                $request->metode_pembayaran
            );

            DB::commit();

            return redirect()->route('barang-keluar.invoice', $nomorTransaksi)
                ->with('success', 'Penjualan berhasil dicatat dan jurnal telah dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * 🆕 Buat Jurnal Otomatis untuk Penjualan Barang
     */
    private function createJurnalPenjualan($nomorTransaksi, $tanggalKeluar, $customer, $totalPenjualan, $totalHPP, $barangDetails, $metodePembayaran)
    {
        // Generate Nomor Jurnal
        $noJurnal = JurnalEntry::generateNoJurnal();

        // Buat keterangan detail
        $itemList = [];
        foreach ($barangDetails as $detail) {
            $itemList[] = "{$detail['jumlah']} unit {$detail['nama']}";
        }
        $keterangan = "Penjualan " . implode(", ", $itemList);
        if ($customer) {
            $keterangan .= " kepada {$customer}";
        }

        // Buat Jurnal Entry
        $jurnalEntry = JurnalEntry::create([
            'no_jurnal' => $noJurnal,
            'tanggal' => $tanggalKeluar,
            'referensi' => $nomorTransaksi,
            'referensi_type' => 'BarangKeluar',
            'keterangan' => $keterangan,
            'user_id' => auth()->id()
        ]);

        // 1. DEBIT: Kas/Bank (Aset bertambah - uang masuk)
        $akunDebet = $metodePembayaran === 'transfer' ? '1102' : '1101';
        
        JurnalDetail::create([
            'jurnal_entry_id' => $jurnalEntry->id,
            'akun_id' => $this->getAkunId($akunDebet),
            'debit' => $totalPenjualan,
            'kredit' => 0,
            'keterangan' => "Penerimaan dari penjualan (" . ucfirst($metodePembayaran) . ")" . ($customer ? " kepada {$customer}" : "")
        ]);

        // 2. KREDIT: Pendapatan Penjualan
        JurnalDetail::create([
            'jurnal_entry_id' => $jurnalEntry->id,
            'akun_id' => $this->getAkunId('4101'),
            'debit' => 0,
            'kredit' => $totalPenjualan,
            'keterangan' => $keterangan
        ]);

        // 3. DEBIT: Beban Pokok Penjualan/HPP (Beban bertambah)
        JurnalDetail::create([
            'jurnal_entry_id' => $jurnalEntry->id,
            'akun_id' => $this->getAkunId('5101'),
            'debit' => $totalHPP,
            'kredit' => 0,
            'keterangan' => "HPP untuk " . $keterangan
        ]);

        // 4. KREDIT: Persediaan Barang (Aset berkurang - stok keluar)
        JurnalDetail::create([
            'jurnal_entry_id' => $jurnalEntry->id,
            'akun_id' => $this->getAkunId('1201'),
            'debit' => 0,
            'kredit' => $totalHPP,
            'keterangan' => "Pengurangan persediaan: " . implode(", ", $itemList)
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

    public function show(BarangKeluar $barangKeluar)
    {
        $barangKeluar->load(['barang', 'serialNumber']);
        return view('barang-keluar.show', compact('barangKeluar'));
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::beginTransaction();
        try {
            // Update stok barang
            $barang = $barangKeluar->barang;
            $barang->increment('stok', 1);

            // Update serial number status
            $serialNumber = $barangKeluar->serialNumber;
            $serialNumber->update([
                'status' => 'READY',
                'tanggal_keluar' => null,
            ]);

            // 🆕 Hapus jurnal terkait (berdasarkan nomor transaksi)
            JurnalEntry::where('referensi', $barangKeluar->nomor_transaksi)
                ->where('referensi_type', 'BarangKeluar')
                ->delete();

            // Hapus transaksi
            $barangKeluar->delete();

            DB::commit();

            return redirect()->route('barang-keluar.index')
                ->with('success', 'Transaksi penjualan dan jurnal berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('barang-keluar.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function invoice($nomorTransaksi)
    {
        $barangKeluar = BarangKeluar::with(['barang', 'serialNumber'])
            ->where('nomor_transaksi', $nomorTransaksi)
            ->get();
            
        if ($barangKeluar->isEmpty()) {
            return redirect()->route('barang-keluar.index')->with('error', 'Transaksi tidak ditemukan');
        }
        
        return view('barang-keluar.invoice', compact('barangKeluar', 'nomorTransaksi'));
    }
}
?>

