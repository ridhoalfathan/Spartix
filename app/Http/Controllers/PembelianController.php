<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::latest()->get();
        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        // Generate ID Pembelian otomatis
        $lastPembelian = Pembelian::latest()->first();
        $nextId = $lastPembelian ? 'PB' . str_pad((int)substr($lastPembelian->id_pembelian, 2) + 1, 5, '0', STR_PAD_LEFT) : 'PB00001';
        
        return view('pembelian.create', compact('nextId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pembelian' => 'required|unique:pembelians,id_pembelian',
            'nama_supplier' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'total_pembelian' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date',
            'status' => 'required|in:Complete,Pending,Cancelled'
        ]);

        Pembelian::create($validated);

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil ditambahkan!');
    }

    public function show(Pembelian $pembelian)
    {
        return view('pembelian.show', compact('pembelian'));
    }

    public function edit(Pembelian $pembelian)
    {
        return view('pembelian.edit', compact('pembelian'));
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $validated = $request->validate([
            'id_pembelian' => 'required|unique:pembelians,id_pembelian,' . $pembelian->id,
            'nama_supplier' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'total_pembelian' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date',
            'status' => 'required|in:Complete,Pending,Cancelled'
        ]);

        $pembelian->update($validated);

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diupdate!');
    }

    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus!');
    }
}