<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    // Tampilkan daftar karyawan
    public function index()
    {
        $karyawans = Karyawan::latest()->get();
        return view('karyawan.index', compact('karyawans'));
    }

    // Form tambah karyawan
    public function create()
    {
        return view('karyawan.create');
    }

    // Simpan data karyawan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_karyawan' => 'required|unique:karyawans,id_karyawan',
            'nama_karyawan' => 'required|string|max:255',
            'jabatan' => 'required|in:Admin,Produksi,Packing,Pengirim,Finishing',
            'kategori' => 'required|in:Mencatat Laporan,Besar,Sedang,Kecil',
            'hasil' => 'nullable|string'
        ]);

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    // Form edit karyawan
    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    // Update data karyawan
    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'id_karyawan' => 'required|unique:karyawans,id_karyawan,' . $karyawan->id,
            'nama_karyawan' => 'required|string|max:255',
            'jabatan' => 'required|in:Admin,Produksi,Packing,Pengirim,Finishing',
            'kategori' => 'required|in:Mencatat Laporan,Besar,Sedang,Kecil',
            'hasil' => 'nullable|string'
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diupdate!');
    }

    // Hapus karyawan
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus!');
    }
}