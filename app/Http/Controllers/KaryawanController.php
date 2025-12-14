<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::orderBy('created_at', 'desc')->get();
        return view('karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'jabatan' => 'required|in:Admin,Produksi,Packing,Pengirim,Finishing'
        ]);

        // Generate ID Karyawan otomatis
        $validated['id_karyawan'] = Karyawan::generateIdKaryawan();

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')
                         ->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'jabatan' => 'required|in:Admin,Produksi,Packing,Pengirim,Finishing'
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($validated);

        return redirect()->route('karyawan.index')
                         ->with('success', 'Karyawan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')
                         ->with('success', 'Karyawan berhasil dihapus!');
    }
}