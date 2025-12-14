<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pesanan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('pesanan.product')->latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        // Ambil pesanan Pending yang belum pernah dibuat transaksinya
        $pesanans = Pesanan::where('status', 'Pending')
            ->whereDoesntHave('transaksi')
            ->with('product')
            ->get();

        return view('transaksi.create', compact('pesanans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
            'nama_pengirim' => 'required|string|max:255',
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:50',
            'total_transaksi' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'status' => 'required|in:Pending,Success,Failed',
        ]);

        DB::beginTransaction();
        try {
            // Generate ID Transaksi
            $validated['id_transaksi'] = Transaksi::generateIdTransaksi();

            // Buat transaksi
            $transaksi = Transaksi::create($validated);

            // Jika status Success, update pesanan dan kurangi stok
            if ($validated['status'] === 'Success') {
                $this->processSuccessfulTransaction($transaksi);
            }

            DB::commit();
            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('pesanan.product');
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $pesanans = Pesanan::where('status', 'Pending')
            ->orWhere('id', $transaksi->pesanan_id)
            ->with('product')
            ->get();

        return view('transaksi.edit', compact('transaksi', 'pesanans'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
            'nama_pengirim' => 'required|string|max:255',
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:50',
            'total_transaksi' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'status' => 'required|in:Pending,Success,Failed',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $transaksi->status;
            $newStatus = $validated['status'];

            // Update transaksi
            $transaksi->update($validated);

            // Jika status berubah dari Pending/Failed ke Success
            if ($oldStatus !== 'Success' && $newStatus === 'Success') {
                $this->processSuccessfulTransaction($transaksi);
            }
            // Jika status berubah dari Success ke Pending/Failed, kembalikan stok
            elseif ($oldStatus === 'Success' && $newStatus !== 'Success') {
                $this->revertSuccessfulTransaction($transaksi);
            }

            DB::commit();
            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Transaksi $transaksi)
    {
        DB::beginTransaction();
        try {
            // Jika transaksi Success, kembalikan stok sebelum hapus
            if ($transaksi->status === 'Success') {
                $this->revertSuccessfulTransaction($transaksi);
            }

            $transaksi->delete();

            DB::commit();
            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Proses transaksi sukses: update pesanan menjadi Complete dan kurangi stok
     */
    private function processSuccessfulTransaction(Transaksi $transaksi)
    {
        $pesanan = Pesanan::with('product')->findOrFail($transaksi->pesanan_id);

        // Cek stok produk
        if ($pesanan->product->stock < $pesanan->jumlah_pesanan) {
            throw new \Exception('Stok produk tidak mencukupi. Stok tersedia: ' . $pesanan->product->stock);
        }

        // Update status pesanan menjadi Complete
        $pesanan->update(['status' => 'Complete']);

        // Kurangi stok produk
        $pesanan->product->decrement('stock', $pesanan->jumlah_pesanan);
    }

    /**
     * Kembalikan perubahan dari transaksi sukses: pesanan kembali Pending dan tambah stok
     */
    private function revertSuccessfulTransaction(Transaksi $transaksi)
    {
        $pesanan = Pesanan::with('product')->findOrFail($transaksi->pesanan_id);

        // Update status pesanan kembali menjadi Pending
        $pesanan->update(['status' => 'Pending']);

        // Kembalikan stok produk
        $pesanan->product->increment('stock', $pesanan->jumlah_pesanan);
    }
}