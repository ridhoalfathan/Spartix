{{-- resources/views/laporan/buku-besar.blade.php --}}
@extends('layouts.main')

@section('title', 'Laporan Buku Besar - RAYA-E')

@section('styles')
<style>
    .page-header {
        background: #ffffff;
        padding: 1.75rem 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
    }
    
    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }
    
    .page-title i {
        color: #2563EB;
        font-size: 2rem;
    }
    
    .page-subtitle {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
        font-weight: 500;
    }
    
    .filter-card {
        background: #ffffff;
        padding: 1.75rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
    }
    
    .form-label {
        font-weight: 700;
        color: #1e3a8a;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    }
    
    .btn-outline-secondary {
        background: white;
        border: 2px solid #e2e8f0;
        color: #64748b;
    }
    
    .btn-outline-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }
    
    .akun-section {
        margin-bottom: 2.5rem;
        page-break-inside: avoid;
    }
    
    .akun-header {
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        padding: 1.25rem 1.5rem;
        border-radius: 16px 16px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }
    
    .akun-header strong {
        font-size: 1.1rem;
        font-weight: 800;
    }
    
    .table-container {
        background: #ffffff;
        border-radius: 0 0 16px 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
        border-top: none;
        overflow: hidden;
    }
    
    .table {
        margin: 0;
        width: 100%;
        font-size: 0.9rem;
    }
    
    .table thead {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }
    
    .table thead th {
        padding: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border: 1px solid #e2e8f0;
        color: #1e3a8a;
    }
    
    .table tbody td {
        padding: 0.875rem;
        vertical-align: middle;
        border: 1px solid #f1f5f9;
        color: #1e3a8a;
        font-weight: 500;
    }
    
    .table tbody tr:hover {
        background: rgba(37, 99, 235, 0.03);
    }
    
    .table-info {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.1) 0%, rgba(2, 132, 199, 0.1) 100%);
        font-weight: 700;
    }
    
    .table-info td {
        border-color: rgba(14, 165, 233, 0.2);
    }
    
    .empty-state {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #2563EB;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .empty-state h4 {
        color: #1e3a8a;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: #64748b;
        margin: 0;
    }
    
    @media (max-width: 768px) {
        .akun-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-journal-bookmark-fill"></i>
        Laporan Buku Besar
    </h1>
    <p class="page-subtitle">Ringkasan saldo dan transaksi per akun</p>
</div>

<!-- Filter Card -->
<div class="filter-card">
    <form action="{{ route('laporan.buku-besar') }}" method="GET" class="row g-3">
        <div class="col-md-2">
            <label class="form-label">Tanggal Dari</label>
            <input type="date" name="tanggal_dari" class="form-control" 
                   value="{{ $tanggalDari }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Tanggal Sampai</label>
            <input type="date" name="tanggal_sampai" class="form-control" 
                   value="{{ $tanggalSampai }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Tipe Akun</label>
            <select name="tipe_akun" class="form-select">
                <option value="">Semua Tipe</option>
                <option value="Aset" {{ request('tipe_akun') == 'Aset' ? 'selected' : '' }}>Aset</option>
                <option value="Liabilitas" {{ request('tipe_akun') == 'Liabilitas' ? 'selected' : '' }}>Liabilitas</option>
                <option value="Ekuitas" {{ request('tipe_akun') == 'Ekuitas' ? 'selected' : '' }}>Ekuitas</option>
                <option value="Pendapatan" {{ request('tipe_akun') == 'Pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                <option value="Beban" {{ request('tipe_akun') == 'Beban' ? 'selected' : '' }}>Beban</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Pilih Akun</label>
            <select name="akun_id" class="form-select">
                <option value="">Semua Akun</option>
                @foreach($akunList as $akun)
                    <option value="{{ $akun->id }}" {{ request('akun_id') == $akun->id ? 'selected' : '' }}>
                        {{ $akun->kode_akun }} - {{ $akun->nama_akun }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary flex-fill">
                <i class="bi bi-search"></i> Filter
            </button>
            <a href="{{ route('laporan.buku-besar') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
            <button type="button" class="btn btn-danger" onclick="exportPDF()" title="Export PDF">
                <i class="bi bi-file-pdf-fill"></i>
            </button>
            <button type="button" class="btn btn-success" onclick="exportExcel()" title="Export Excel">
                <i class="bi bi-file-earmark-excel-fill"></i>
            </button>
        </div>
    </form>
</div>

<!-- Detail per Akun -->
@forelse($bukuBesar as $item)
<div class="akun-section">
    <!-- Header Akun -->
    <div class="akun-header">
        <strong>Nama Akun: {{ $item['akun']->nama_akun }}</strong>
        <strong>Kode Akun: {{ $item['akun']->kode_akun }}</strong>
    </div>

    <!-- Tabel Transaksi -->
    <div class="table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" class="align-middle text-center" style="width: 12%;">Tanggal</th>
                    <th rowspan="2" class="align-middle" style="width: 30%;">Keterangan</th>
                    <th rowspan="2" class="align-middle text-center" style="width: 8%;">Ref</th>
                    <th rowspan="2" class="align-middle text-end" style="width: 12%;">Debit (Rp)</th>
                    <th rowspan="2" class="align-middle text-end" style="width: 12%;">Kredit (Rp)</th>
                    <th colspan="2" class="text-center" style="width: 26%;">Saldo</th>
                </tr>
                <tr>
                    <th class="text-end" style="width: 13%;">Debit</th>
                    <th class="text-end" style="width: 13%;">Kredit</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $saldoDebit = 0;
                    $saldoKredit = 0;
                    
                    // Saldo awal
                    if(isset($item['saldo_awal'])) {
                        if($item['akun']->posisi_normal == 'Debit') {
                            $saldoDebit = $item['saldo_awal'] >= 0 ? $item['saldo_awal'] : 0;
                            $saldoKredit = $item['saldo_awal'] < 0 ? abs($item['saldo_awal']) : 0;
                        } else {
                            $saldoKredit = $item['saldo_awal'] >= 0 ? $item['saldo_awal'] : 0;
                            $saldoDebit = $item['saldo_awal'] < 0 ? abs($item['saldo_awal']) : 0;
                        }
                    }
                    
                    $tampilSaldoDebit = $saldoDebit;
                    $tampilSaldoKredit = $saldoKredit;
                @endphp
                
                <!-- Saldo Awal -->
                <tr class="table-info">
                    <td class="text-center fw-bold">
                        {{ isset($tanggalDari) ? \Carbon\Carbon::parse($tanggalDari)->format('M Y') : \Carbon\Carbon::now()->format('M Y') }}
                    </td>
                    <td class="fw-bold" colspan="4">SALDO AWAL</td>
                    <td class="text-end fw-bold">
                        {{ $saldoDebit > 0 ? number_format($saldoDebit, 0, ',', '.') : '' }}
                    </td>
                    <td class="text-end fw-bold">
                        {{ $saldoKredit > 0 ? number_format($saldoKredit, 0, ',', '.') : '' }}
                    </td>
                </tr>

                <!-- Transaksi -->
                @if(isset($item['transaksi']) && count($item['transaksi']) > 0)
                    @foreach($item['transaksi'] as $transaksi)
                    @php
                        // Update saldo berdasarkan posisi normal akun
                        if($item['akun']->posisi_normal == 'Debit') {
                            $saldoDebit += $transaksi->debit;
                            $saldoKredit += $transaksi->kredit;
                        } else {
                            $saldoKredit += $transaksi->kredit;
                            $saldoDebit += $transaksi->debit;
                        }
                        
                        // Hitung saldo bersih
                        $saldoBersih = $saldoDebit - $saldoKredit;
                        $tampilSaldoDebit = $saldoBersih > 0 ? $saldoBersih : 0;
                        $tampilSaldoKredit = $saldoBersih < 0 ? abs($saldoBersih) : 0;
                    @endphp
                    <tr>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}
                        </td>
                        <td>{{ $transaksi->keterangan ?? '-' }}</td>
                        <td class="text-center">{{ $transaksi->ref ?? '' }}</td>
                        <td class="text-end">
                            @if($transaksi->debit > 0)
                            <strong style="color: #10b981;">
                                {{ number_format($transaksi->debit, 0, ',', '.') }}
                            </strong>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($transaksi->kredit > 0)
                            <strong style="color: #ef4444;">
                                {{ number_format($transaksi->kredit, 0, ',', '.') }}
                            </strong>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($tampilSaldoDebit > 0)
                            <strong>{{ number_format($tampilSaldoDebit, 0, ',', '.') }}</strong>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($tampilSaldoKredit > 0)
                            <strong>{{ number_format($tampilSaldoKredit, 0, ',', '.') }}</strong>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endif
                
                <!-- Saldo Akhir -->
                <tr class="table-info">
                    <td class="text-center fw-bold" colspan="5">SALDO AKHIR</td>
                    <td class="text-end fw-bold">
                        {{ $tampilSaldoDebit > 0 ? number_format($tampilSaldoDebit, 0, ',', '.') : '' }}
                    </td>
                    <td class="text-end fw-bold">
                        {{ $tampilSaldoKredit > 0 ? number_format($tampilSaldoKredit, 0, ',', '.') : '' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="empty-state">
    <i class="bi bi-inbox-fill"></i>
    <h4>Tidak Ada Data</h4>
    <p>Belum ada data buku besar untuk periode ini</p>
</div>
@endforelse

<script>
function exportPDF() {
    const url = new URL(window.location.href);
    url.searchParams.set('export', 'pdf');
    window.location.href = url.toString();
}
function exportExcel() {
    const url = new URL(window.location.href);
    url.searchParams.set('export', 'excel');
    window.location.href = url.toString();
}
</script>
@endsection

