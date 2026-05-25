<?php

namespace App\Http\Controllers;

use App\Models\SerialNumber;
use App\Models\Barang;
use Illuminate\Http\Request;

class SerialNumberController extends Controller
{
    public function index(Request $request)
    {
        $query = SerialNumber::with(['barang', 'barangMasuk']);

        // Filter by barang
        if ($request->has('barang_id') && $request->barang_id != '') {
            $query->where('barang_id', $request->barang_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search by serial number
        if ($request->has('search') && $request->search != '') {
            $query->where('serial_number', 'like', '%' . $request->search . '%');
        }

        $serialNumbers = $query->orderBy('created_at', 'desc')->paginate(10);
        $barang = Barang::orderBy('nama_barang')->get();

        return view('serial-numbers.index', compact('serialNumbers', 'barang'));
    }

    public function show(SerialNumber $serialNumber)
    {
        $serialNumber->load(['barang', 'barangMasuk', 'barangKeluar']);
        return view('serial-numbers.show', compact('serialNumber'));
    }
}