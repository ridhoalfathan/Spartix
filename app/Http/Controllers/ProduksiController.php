<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\Karyawan;
use App\Models\Product;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function index()
    {
        $produksis = Produksi::with(['product', 'karyawan'])->latest()->get();
        return view('produksi.index', compact('produksis'));
    }

    public function create()
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        $karyawans = Karyawan::orderBy('nama_karyawan', 'asc')->get();
        return view('produksi.create', compact('products', 'karyawans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:Selesai,Belum Diproses,Sedang Diproses,Dibatalkan,Proses,Menunggu Bahan',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'product_id.required' => 'Produk harus dipilih',
            'product_id.exists' => 'Produk tidak valid',
            'karyawan_id.required' => 'Karyawan harus dipilih',
            'karyawan_id.exists' => 'Karyawan tidak valid',
            'tanggal.required' => 'Tanggal harus diisi',
            'waktu.required' => 'Waktu harus diisi',
            'quantity.required' => 'Jumlah produksi harus diisi',
            'quantity.integer' => 'Jumlah produksi harus berupa angka',
            'quantity.min' => 'Jumlah produksi minimal 1',
            'status.required' => 'Status harus dipilih',
        ]);

        $produksi = Produksi::create($validated);

        // Jika langsung dibuat dengan status Selesai, tambah stok
        if ($validated['status'] === 'Selesai') {
            $produksi->product->addStock($validated['quantity']);
        }

        return redirect()->route('produksi.index')
            ->with('success', 'Data produksi berhasil ditambahkan!');
    }

    public function show(Produksi $produksi)
    {
        $produksi->load(['product', 'karyawan']);
        return view('produksi.show', compact('produksi'));
    }

    public function edit(Produksi $produksi)
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        $karyawans = Karyawan::orderBy('nama_karyawan', 'asc')->get();
        return view('produksi.edit', compact('produksi', 'products', 'karyawans'));
    }

    public function update(Request $request, Produksi $produksi)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:Selesai,Belum Diproses,Sedang Diproses,Dibatalkan,Proses,Menunggu Bahan',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Update akan trigger event di Model yang akan handle penambahan stok otomatis
        $produksi->update($validated);

        return redirect()->route('produksi.index')
            ->with('success', 'Data produksi berhasil diperbarui! ' . 
                   ($validated['status'] === 'Selesai' ? 'Stok produk telah ditambahkan.' : ''));
    }

    public function destroy(Produksi $produksi)
    {
        // Jika produksi dengan status Selesai dihapus, kurangi stok
        if ($produksi->status === 'Selesai') {
            $produksi->product->reduceStock($produksi->quantity);
        }

        $produksi->delete();

        return redirect()->route('produksi.index')
            ->with('success', 'Data produksi berhasil dihapus!');
    }
}