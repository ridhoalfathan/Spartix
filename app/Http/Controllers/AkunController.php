<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $query = Akun::with('parent');

        if ($request->filled('tipe_akun')) {
            $query->where('tipe_akun', $request->tipe_akun);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_akun', 'like', "%{$search}%")
                  ->orWhere('nama_akun', 'like', "%{$search}%");
            });
        }

        $akunList = $query->orderBy('kode_akun')->paginate(15);

        return view('akun.index', compact('akunList'));
    }

    public function create()
    {
        $parentAccounts = Akun::active()->orderBy('kode_akun')->get();
        return view('akun.create', compact('parentAccounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_akun'     => 'required|string|max:20|unique:akuns,kode_akun',
            'nama_akun'     => 'required|string|max:255',
            'tipe_akun'     => 'required|in:Aset,Liabilitas,Ekuitas,Pendapatan,Beban',
            'kategori'      => 'nullable|in:Lancar,Tidak Lancar,Operasional,Non-Operasional',
            'saldo_normal'  => 'required|numeric|min:0',
            'posisi_normal' => 'required|in:Debit,Kredit',
            'parent_id'     => 'nullable|exists:akuns,id',
            'deskripsi'     => 'nullable|string',
            'is_active'     => 'boolean',
        ]);

        Akun::create($validated);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function show(Akun $akun)
    {
        return redirect()->route('akun.edit', $akun);
    }

    public function edit(Akun $akun)
    {
        $parentAccounts = Akun::active()
            ->where('id', '!=', $akun->id)
            ->orderBy('kode_akun')
            ->get();

        return view('akun.edit', compact('akun', 'parentAccounts'));
    }

    public function update(Request $request, Akun $akun)
    {
        $validated = $request->validate([
            'kode_akun'     => 'required|string|max:20|unique:akuns,kode_akun,' . $akun->id,
            'nama_akun'     => 'required|string|max:255',
            'tipe_akun'     => 'required|in:Aset,Liabilitas,Ekuitas,Pendapatan,Beban',
            'kategori'      => 'nullable|in:Lancar,Tidak Lancar,Operasional,Non-Operasional',
            'saldo_normal'  => 'required|numeric|min:0',
            'posisi_normal' => 'required|in:Debit,Kredit',
            'parent_id'     => 'nullable|exists:akuns,id',
            'deskripsi'     => 'nullable|string',
            'is_active'     => 'boolean',
        ]);

        $akun->update($validated);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui!');
    }

    public function destroy(Akun $akun)
    {
        if ($akun->children()->count() > 0) {
            return redirect()->route('akun.index')
                ->with('error', 'Tidak dapat menghapus akun yang memiliki sub akun!');
        }

        $akun->delete();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus!');
    }
}
