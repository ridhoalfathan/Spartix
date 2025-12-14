<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Product;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with('product')->latest()->get();
        return view('pesanan.index', compact('pesanans'));
    }

    public function create()
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        return view('pesanan.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'nama_pemesan' => 'required|string|max:255',
            'jumlah_pesanan' => 'required|integer|min:1',
            'tanggal_pembayaran' => 'required|date',
            'status' => 'required|in:Complete,Pending',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Hitung total harga (jika kolom tersedia)
        if ($product->harga ?? false) {
            $validated['total_harga'] = $product->harga * $validated['jumlah_pesanan'];
        }

        // Cek stock jika status Complete
        if ($validated['status'] === 'Complete') 
        {
            if ($product->stock < $validated['jumlah_pesanan']) {
                return back()->withInput()
                    ->with('error', 'Stock tidak mencukupi! Stock tersedia: '.$product->stock);
            }

            $product->stock -= $validated['jumlah_pesanan'];
            $product->save();
        }

        Pesanan::create($validated);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil ditambahkan!');
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load('product');
        return view('pesanan.show', compact('pesanan'));
    }

    public function edit(Pesanan $pesanan)
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        return view('pesanan.edit', compact('pesanan', 'products'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'nama_pemesan' => 'required|string|max:255',
            'jumlah_pesanan' => 'required|integer|min:1',
            'tanggal_pembayaran' => 'required|date',
            'status' => 'required|in:Complete,Pending',
        ]);

        $oldStatus = $pesanan->status;
        $newStatus = $validated['status'];
        $oldQty = $pesanan->jumlah_pesanan;
        $newQty = $validated['jumlah_pesanan'];

        $oldProduct = Product::find($pesanan->product_id);
        $newProduct = Product::find($validated['product_id']);

        // Status berubah dari Pending → Complete
        if ($oldStatus === 'Pending' && $newStatus === 'Complete') 
        {
            if ($newProduct->stock < $newQty) {
                return back()->withInput()
                    ->with('error', 'Stock tidak mencukupi! Stock tersedia: '.$newProduct->stock);
            }

            $newProduct->stock -= $newQty;
            $newProduct->save();
        }

        // Status berubah dari Complete → Pending (kembalikan stock)
        if ($oldStatus === 'Complete' && $newStatus === 'Pending')
        {
            $oldProduct->stock += $oldQty;
            $oldProduct->save();
        }

        // Reset total harga
        if ($newProduct->harga ?? false) {
            $validated['total_harga'] = $newProduct->harga * $newQty;
        }

        $pesanan->update($validated);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy(Pesanan $pesanan)
    {
        // Jika pesanan Complete, kembalikan stock
        if ($pesanan->status === 'Complete') {
            $product = $pesanan->product;
            if ($product) {
                $product->stock += $pesanan->jumlah_pesanan;
                $product->save();
            }
        }

        $pesanan->delete();

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }
}
