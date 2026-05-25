@extends('layouts.main')

@section('title', 'Laporan Penjualan - RAYA-E')

@section('styles')
<style>
    .page-header {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }
    
    .page-title i {
        color: #22c55e;
    }
    
    .btn-export {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        color: white;
    }
    
    .btn-export-excel {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-export-excel:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .filter-card {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1.2fr 1.2fr auto;
        gap: 1rem;
        align-items: end;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.625rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        outline: none;
    }
    
    .btn-filter {
        background: #22c55e;
        color: white;
        padding: 0.625rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-filter:hover {
        background: #16a34a;
    }
    
    .btn-reset {
        background: #94a3b8;
        color: white;
        padding: 0.625rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-reset:hover {
        background: #64748b;
    }
    
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-box {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }
    
    .stat-value {
        font-size: 1.75rem;
        font-weight: 900;
        color: #1e3a8a;
    }
    
    .stat-value.success {
        color: #22c55e;
    }
    
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .table {
        margin: 0;
    }
    
    .table thead {
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        color: white;
    }
    
    .table thead th {
        padding: 1.25rem 1rem;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table tbody tr:hover {
        background: rgba(34, 197, 94, 0.05);
    }
    
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #64748b;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
        }
        
        .filter-row, .stats-summary {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-graph-up"></i>
        Laporan Penjualan
    </h1>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('laporan.penjualan') }}?export=excel&{{ http_build_query(request()->except('export')) }}" class="btn-export-excel">
            <i class="bi bi-file-earmark-excel"></i>
            Export Excel
        </a>
        <a href="{{ route('laporan.penjualan') }}?export=pdf&{{ http_build_query(request()->except('export')) }}" class="btn-export">
            <i class="bi bi-file-earmark-pdf"></i>
            Export PDF
        </a>
    </div>
</div>

<!-- Filter Card -->
<div class="filter-card">
    <form action="{{ route('laporan.penjualan') }}" method="GET">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Cari Barang</label>
                <input type="text" name="search" class="form-control" placeholder="Nama, kode, merk..." value="{{ request('search') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Barang</label>
                <select name="barang_id" class="form-select">
                    <option value="">Semua Barang</option>
                    @foreach($barang as $item)
                    <option value="{{ $item->id }}" {{ request('barang_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_barang }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group" style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('laporan.penjualan') }}" class="btn-reset">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Statistics Summary -->
<div class="stats-summary">
    <div class="stat-box">
        <div class="stat-label">Total HPP</div>
        <div class="stat-value">Rp {{ number_format($totalHPP, 0, ',', '.') }}</div>
    </div>
    
    <div class="stat-box">
        <div class="stat-label">Total Penjualan</div>
        <div class="stat-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
    </div>
    
    <div class="stat-box">
        <div class="stat-label">Total Laba</div>
        <div class="stat-value success">Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
    </div>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-responsive">
        @if($penjualan->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>TANGGAL</th>
                    <th>NO TRANSAKSI</th>
                    <th>BARANG</th>
                    <th>JUMLAH</th>
                    <th>HPP</th>
                    <th>HARGA JUAL</th>
                    <th>LABA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                    <td><strong>{{ $item->nomor_transaksi }}</strong></td>
                    <td>
                        <strong>{{ $item->barang->nama_barang }}</strong><br>
                        <small style="color: #64748b;">{{ $item->barang->kode_barang }}</small>
                    </td>
                    <td>{{ $item->jumlah }} Unit</td>
                    <td>Rp {{ number_format($item->hpp, 0, ',', '.') }}</td>
                    <td><strong>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</strong></td>
                    <td>
                        <strong style="color: {{ $item->laba >= 0 ? '#22c55e' : '#ef4444' }};">
                            {{ $item->laba >= 0 ? '+' : '' }}Rp {{ number_format($item->laba, 0, ',', '.') }}
                        </strong>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h4>Tidak Ada Data</h4>
            <p>Tidak ada transaksi penjualan sesuai filter yang dipilih.</p>
        </div>
        @endif
    </div>
</div>

<div style="margin-top: 1rem; font-size: 0.85rem; color: #64748b; font-style: italic;">
    * Catatan: Beban Pokok Penjualan (HPP) dan Laba dihitung secara otomatis menggunakan metode <strong>First-In, First-Out (FIFO)</strong> berdasarkan harga beli unit nomor seri yang keluar.
</div>
@endsection