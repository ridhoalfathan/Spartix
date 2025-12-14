<?php

namespace App\Http\Controllers;

use App\Models\SalaryReport;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use PDF; // Pastikan sudah install: composer require barryvdh/laravel-dompdf

class SalaryReportController extends Controller
{
    public function index(Request $request)
    {
        $query = SalaryReport::with('karyawan');

        // Filter by jabatan
        if ($request->filled('jabatan')) {
            $query->whereHas('karyawan', function($q) use ($request) {
                $q->where('jabatan', $request->jabatan);
            });
        }

        // Filter by tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $salaryReports = $query->latest('tanggal')->get();
        $jabatans = Karyawan::distinct()->pluck('jabatan');

        return view('salary-report.index', compact('salaryReports', 'jabatans'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('salary-report.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'gaji_per_jam' => 'required|numeric|min:0',
            'lama_bekerja' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
        ]);

        $validated['bonus'] = $validated['bonus'] ?? 0;

        SalaryReport::create($validated);

        return redirect()->route('salary-report.index')
            ->with('success', 'Salary report berhasil ditambahkan!');
    }

    public function show(SalaryReport $salaryReport)
    {
        $salaryReport->load('karyawan');
        return view('salary-report.show', compact('salaryReport'));
    }

    public function edit(SalaryReport $salaryReport)
    {
        $karyawans = Karyawan::all();
        return view('salary-report.edit', compact('salaryReport', 'karyawans'));
    }

    public function update(Request $request, SalaryReport $salaryReport)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'gaji_per_jam' => 'required|numeric|min:0',
            'lama_bekerja' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
        ]);

        $validated['bonus'] = $validated['bonus'] ?? 0;

        $salaryReport->update($validated);

        return redirect()->route('salary-report.index')
            ->with('success', 'Salary report berhasil diupdate!');
    }

    public function destroy(SalaryReport $salaryReport)
    {
        $salaryReport->delete();

        return redirect()->route('salary-report.index')
            ->with('success', 'Salary report berhasil dihapus!');
    }

    public function exportPdf(Request $request)
    {
        $query = SalaryReport::with('karyawan');

        if ($request->filled('jabatan')) {
            $query->whereHas('karyawan', function($q) use ($request) {
                $q->where('jabatan', $request->jabatan);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $salaryReports = $query->latest('tanggal')->get();
        $filterJabatan = $request->jabatan;
        $filterTanggal = $request->tanggal;

        $pdf = PDF::loadView('salary-report.pdf', compact('salaryReports', 'filterJabatan', 'filterTanggal'));
        
        return $pdf->download('salary-report-' . date('Y-m-d') . '.pdf');
    }
    public function markPaid($id)
{
    $report = SalaryReport::findOrFail($id);

    if (! $report->canBePaid()) {
        return back()->with('error', 'Laporan ini tidak dapat ditandai sebagai dibayar.');
    }

    $report->status = 'paid'; // pastikan kolom ini ada
    $report->save();

    return redirect()->route('salary-report.index')
                     ->with('success', 'Gaji berhasil ditandai sebagai dibayar.');
}

}