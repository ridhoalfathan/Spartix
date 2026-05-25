<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        // Filter Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%')
                  ->orWhere('merk', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        // Filter Kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Filter Status Stok
        if ($request->has('status') && $request->status != '') {
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

        $barang = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get distinct categories for filter
        $categories = Barang::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        
        return view('barang.index', compact('barang', 'categories'));
    }

    public function create()
    {
        // Get existing categories for suggestions
        $categories = Barang::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('barang.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'merk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:1',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi',
            'kategori.required' => 'Kategori wajib diisi',
            'merk.required' => 'Merk wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal 0',
            'stok_minimum.required' => 'Stok minimum wajib diisi',
            'stok_minimum.min' => 'Stok minimum minimal 1',
        ]);

        // Generate kode barang otomatis
        $kodeBarang = $this->generateKodeBarang($request->kategori);

        Barang::create([
            'kode_barang' => $kodeBarang,
            'nama_barang' => $request->nama_barang,
            'kategori' => ucfirst($request->kategori),
            'merk' => $request->merk,
            'harga' => $request->harga,
            'stok' => 0,
            'stok_minimum' => $request->stok_minimum,
            'metode' => 'FIFO',
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan! Kode: ' . $kodeBarang);
    }

    public function show(Barang $barang)
    {
        $barang->load(['serialNumbers', 'barangMasuk', 'barangKeluar']);
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $categories = Barang::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('barang.edit', compact('barang', 'categories'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'merk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:1',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi',
            'kategori.required' => 'Kategori wajib diisi',
            'merk.required' => 'Merk wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal 0',
            'stok_minimum.required' => 'Stok minimum wajib diisi',
            'stok_minimum.min' => 'Stok minimum minimal 1',
        ]);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori' => ucfirst($request->kategori),
            'merk' => $request->merk,
            'harga' => $request->harga,
            'stok_minimum' => $request->stok_minimum,
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->stok > 0) {
            return redirect()->route('barang.index')
                ->with('error', 'Tidak dapat menghapus barang yang masih memiliki stok!');
        }

        $namaBarang = $barang->nama_barang;
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang "' . $namaBarang . '" berhasil dihapus!');
    }

    private function generateKodeBarang($kategori)
    {
        // Get first 2-3 letters of category for prefix
        $prefix = strtoupper(substr($kategori, 0, 3));

        $lastBarang = Barang::where('kategori', $kategori)
            ->latest()
            ->first();

        if ($lastBarang) {
            $lastNumber = intval(substr($lastBarang->kode_barang, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}