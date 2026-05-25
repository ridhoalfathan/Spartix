{{-- resources/views/laporan/jurnal-umum.blade.php --}}
@extends('layouts.main')

@section('title', 'Laporan Jurnal Umum - RAYA-E')

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
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: #ffffff;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .stat-icon.primary {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(30, 64, 175, 0.1) 100%);
        color: #2563EB;
    }
    
    .stat-icon.success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
        color: #10b981;
    }
    
    .stat-icon.warning {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
        color: #f59e0b;
    }
    
    .stat-content h6 {
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-content h3 {
        color: #1e3a8a;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0;
    }
    
    .jurnal-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .jurnal-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 1.25rem 1.5rem;
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .jurnal-header-left h5 {
        color: #2563EB;
        font-weight: 800;
        font-size: 1.1rem;
        margin: 0 0 0.25rem 0;
    }
    
    .jurnal-header-left small {
        color: #64748b;
        font-weight: 600;
    }
    
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .table {
        margin: 0;
        width: 100%;
    }
    
    .table thead {
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        color: white;
    }
    
    .table thead th {
        padding: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #1e3a8a;
        font-weight: 500;
    }
    
    .table tbody tr:hover {
        background: rgba(37, 99, 235, 0.05);
    }
    
    .table .total-row {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        font-weight: 800;
    }
    
    .akun-kredit {
        display: inline-block;
        padding-left: 2rem;
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
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .jurnal-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }
    
    @media print {
        .filter-card, .btn, .page-header {
            display: none !important;
        }
        
        .jurnal-card {
            box-shadow: none;
            border: 1px solid #dee2e6;
            page-break-inside: avoid;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-book-fill"></i>
        Laporan Jurnal Umum
    </h1>
    <p class="page-subtitle">Catatan transaksi keuangan berdasarkan urutan waktu</p>
</div>

<!-- Filter Card -->
<div class="filter-card">
    <form action="{{ route('laporan.jurnal-umum') }}" method="GET" class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Tanggal Dari</label>
            <input type="date" name="tanggal_dari" class="form-control" 
                   value="{{ $tanggalDari }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Sampai</label>
            <input type="date" name="tanggal_sampai" class="form-control" 
                   value="{{ $tanggalSampai }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">No. Jurnal</label>
            <input type="text" name="no_jurnal" class="form-control" 
                   placeholder="Cari nomor jurnal..."
                   value="{{ request('no_jurnal') }}">
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary flex-fill">
                <i class="bi bi-search"></i> Filter
            </button>
            <a href="{{ route('laporan.jurnal-umum') }}" class="btn btn-outline-secondary">
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

<!-- Summary Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="bi bi-journal-text"></i>
        </div>
        <div class="stat-content">
            <h6>Total Jurnal</h6>
            <h3>{{ $jurnalEntries->total() }}</h3>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="bi bi-arrow-down-circle-fill"></i>
        </div>
        <div class="stat-content">
            <h6>Total Debit</h6>
            <h3>Rp {{ number_format($jurnalEntries->getCollection()->sum('total_debit'), 0, ',', '.') }}</h3>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="bi bi-arrow-up-circle-fill"></i>
        </div>
        <div class="stat-content">
            <h6>Total Kredit</h6>
            <h3>Rp {{ number_format($jurnalEntries->getCollection()->sum('total_kredit'), 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<!-- Jurnal Entries -->
<div class="jurnal-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width: 12%;">TANGGAL</th>
                    <th style="width: 38%;">KETERANGAN</th>
                    <th style="width: 15%;">REF</th>
                    <th style="width: 17.5%;" class="text-end">DEBIT</th>
                    <th style="width: 17.5%;" class="text-end">KREDIT</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jurnalEntries as $jurnal)
                    @foreach($jurnal->details as $index => $detail)
                    <tr>
                        <td>
                            @if($index === 0)
                                <strong>{{ $jurnal->tanggal->format('d/m/Y') }}</strong>
                            @endif
                        </td>
                        <td>
                            @if($detail->debit > 0)
                                <span>{{ $detail->akun?->kode_akun }} - {{ $detail->akun?->nama_akun ?? '(akun tidak ditemukan)' }}</span>
                            @else
                                <span class="akun-kredit">{{ $detail->akun?->kode_akun }} - {{ $detail->akun?->nama_akun ?? '(akun tidak ditemukan)' }}</span>
                            @endif
                        </td>
                        <td>
                            @if($index === 0)
                                <span class="badge" style="background: rgba(37, 99, 235, 0.1); color: #2563EB;">
                                    {{ $jurnal->no_jurnal }}
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($detail->debit > 0)
                                <strong style="color: #10b981;">
                                    Rp {{ number_format($detail->debit, 0, ',', '.') }}
                                </strong>
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($detail->kredit > 0)
                                <strong style="color: #ef4444;">
                                    Rp {{ number_format($detail->kredit, 0, ',', '.') }}
                                </strong>
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <!-- Spacer between journals -->
                    <tr style="height: 15px; border-bottom: 2px solid #e2e8f0; background-color: transparent;">
                        <td colspan="5" style="padding: 0; border: none;"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state" style="border: none; box-shadow: none;">
                                <i class="bi bi-inbox-fill"></i>
                                <h4>Tidak Ada Data</h4>
                                <p>Belum ada jurnal umum yang tersedia untuk periode ini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                
                @if($jurnalEntries->count() > 0)
                <tr style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-top: 2px solid #1e3a8a;">
                    <td colspan="3" class="text-end" style="font-weight: 800; color: #1e3a8a;">TOTAL HALAMAN INI</td>
                    <td class="text-end" style="font-weight: 800; color: #10b981;">
                        Rp {{ number_format($jurnalEntries->getCollection()->sum('total_debit'), 0, ',', '.') }}
                    </td>
                    <td class="text-end" style="font-weight: 800; color: #ef4444;">
                        Rp {{ number_format($jurnalEntries->getCollection()->sum('total_kredit'), 0, ',', '.') }}
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($jurnalEntries->hasPages())
<div style="margin-top: 2rem; display: flex; justify-content: center;">
    {{ $jurnalEntries->links('pagination::bootstrap-5') }}
</div>
@endif

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

