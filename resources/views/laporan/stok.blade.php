@extends('layouts.main')

@section('title', 'Laporan Stok - RAYA-E')

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
        color: #2563EB;
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
        grid-template-columns: 2fr 1fr 1fr auto;
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
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
    }
    
    .btn-filter {
        background: #2563EB;
        color: white;
        padding: 0.625rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-filter:hover {
        background: #1d4ed8;
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
        background: rgba(37, 99, 235, 0.05);
    }
    
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
        display: inline-block;
    }
    
    .badge-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }
    
    .badge-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    
    .badge-danger {
        background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
        color: #991b1b;
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
        
        .filter-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-clipboard-data"></i>
        Laporan Stok Barang
    </h1>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('laporan.stok') }}?export=excel&{{ http_build_query(request()->except('export')) }}" class="btn-export-excel">
            <i class="bi bi-file-earmark-excel"></i>
            Export Excel
        </a>
        <a href="{{ route('laporan.stok') }}?export=pdf&{{ http_build_query(request()->except('export')) }}" class="btn-export">
            <i class="bi bi-file-earmark-pdf"></i>
            Export PDF
        </a>
    </div>
</div>

<!-- Filter Card -->
<div class="filter-card">
    <form action="{{ route('laporan.stok') }}" method="GET">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">Cari Barang</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari nama, kode, atau merk..."
                       value="{{ request('search') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="TV" {{ request('kategori') == 'TV' ? 'selected' : '' }}>TV</option>
                    <option value="AC" {{ request('kategori') == 'AC' ? 'selected' : '' }}>AC</option>
                    <option value="Kulkas" {{ request('kategori') == 'Kulkas' ? 'selected' : '' }}>Kulkas</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Status Stok</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="normal" {{ request('status') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="rendah" {{ request('status') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            
            <div class="form-group" style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('laporan.stok') }}" class="btn-reset">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-responsive">
        @if($barang->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>KODE</th>
                    <th>NAMA BARANG</th>
                    <th>KATEGORI</th>
                    <th>MERK</th>
                    <th>STOK</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $item->kode_barang }}</strong></td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>
                        <span class="badge-category badge-{{ strtolower($item->kategori) }}">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td>{{ $item->merk }}</td>
                    <td><strong>{{ $item->stok }}</strong> Unit</td>
                    <td>
                        @if($item->stok <= 0)
                            <span class="badge badge-danger">
                                <i class="bi bi-x-circle"></i> Habis
                            </span>
                        @elseif($item->stok <= $item->stok_minimum)
                            <span class="badge badge-warning">
                                <i class="bi bi-exclamation-triangle"></i> Rendah
                            </span>
                        @else
                            <span class="badge badge-success">
                                <i class="bi bi-check-circle"></i> Normal
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h4>Tidak Ada Data</h4>
            <p>Tidak ada data barang sesuai filter yang dipilih.</p>
        </div>
        @endif
    </div>
</div>

<!-- Summary -->
@if($barang->count() > 0)
<div style="margin-top: 2rem; background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);">
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
        <div>
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; margin-bottom: 0.5rem;">Total Item</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #2563EB;">{{ $barang->count() }}</div>
        </div>
        <div>
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; margin-bottom: 0.5rem;">Total Stok</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #22c55e;">{{ $barang->sum('stok') }} Unit</div>
        </div>
        <div>
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; margin-bottom: 0.5rem;">Tanggal Cetak</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #1e3a8a;">{{ date('d/m/Y') }}</div>
        </div>
    </div>
</div>
@endif
@endsection