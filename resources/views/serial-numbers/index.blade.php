@extends('layouts.main')

@section('title', 'Manajemen Serial Number - RAYA-E')

@section('styles')
<style>
    /* Stats cards - komponen khusus halaman ini */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: #ffffff;
        padding: 1.75rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(37, 99, 235, 0.15);
    }
    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        flex-shrink: 0;
    }
    .stat-icon.blue  { background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%); }
    .stat-icon.green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .stat-icon.red   { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    .stat-info { flex: 1; }
    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    .stat-value {
        font-size: 1.875rem;
        font-weight: 900;
        color: #1e3a8a;
        letter-spacing: -1px;
    }
    .serial-code {
        font-family: 'Courier New', monospace;
        font-weight: 800;
        color: #2563EB;
        background: rgba(37, 99, 235, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        display: inline-block;
        border: 2px solid rgba(37, 99, 235, 0.2);
    }
    @media (max-width: 1200px) { .stats-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px)  { .stats-row { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-upc-scan"></i>
            Manajemen Serial Number
        </h1>
        <p style="color: #64748b; margin: 0.5rem 0 0 0; font-size: 0.95rem; font-weight: 600;">
            Tracking dan monitoring serial number barang elektronik
        </p>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="bi bi-upc"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Serial Number</div>
            <div class="stat-value">{{ number_format($serialNumbers->total(), 0, ',', '.') }}</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Status Ready</div>
            <div class="stat-value">{{ number_format(\App\Models\SerialNumber::where('status', 'READY')->count(), 0, ',', '.') }}</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="bi bi-x-circle-fill"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Status Terjual</div>
            <div class="stat-value">{{ number_format(\App\Models\SerialNumber::where('status', 'TERJUAL')->count(), 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<!-- Filter Card -->
<div class="filter-card">
    <form action="{{ route('serial-numbers.index') }}" method="GET">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">🔍 Cari Serial Number</label>
                <input type="text" name="search" class="form-control" placeholder="Masukkan serial number..." value="{{ request('search') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">📦 Barang</label>
                <select name="barang_id" class="form-select">
                    <option value="">Semua Barang</option>
                    @foreach($barang as $item)
                    <option value="{{ $item->id }}" {{ request('barang_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_barang }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">📊 Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="READY"   {{ request('status') == 'READY'   ? 'selected' : '' }}>Ready</option>
                    <option value="TERJUAL" {{ request('status') == 'TERJUAL' ? 'selected' : '' }}>Terjual</option>
                </select>
            </div>
            
            <div class="form-group" style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('serial-numbers.index') }}" class="btn-reset">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-responsive">
        @if($serialNumbers->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>SERIAL NUMBER</th>
                    <th>BARANG</th>
                    <th>KATEGORI</th>
                    <th>HARGA BELI</th>
                    <th>TANGGAL MASUK</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serialNumbers as $index => $sn)
                <tr>
                    <td><strong>{{ $serialNumbers->firstItem() + $index }}</strong></td>
                    <td>
                        <span class="serial-code">{{ $sn->serial_number }}</span>
                    </td>
                    <td>
                        <strong>{{ $sn->barang->nama_barang }}</strong><br>
                        <small style="color: #64748b; font-weight: 600;">{{ $sn->barang->merk }}</small>
                    </td>
                    <td>
                        <span class="badge-category">
                            {{ $sn->barang->kategori }}
                        </span>
                    </td>
                    <td style="color: #10b981; font-weight: 700;">Rp {{ number_format($sn->harga_beli, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($sn->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td>
                        @if($sn->status == 'READY')
                            <span class="badge badge-success">
                                <i class="bi bi-check-circle-fill"></i> READY
                            </span>
                        @else
                            <span class="badge badge-secondary">
                                <i class="bi bi-x-circle-fill"></i> TERJUAL
                            </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('serial-numbers.show', $sn->id) }}" class="btn-action btn-action-view" title="Detail">
                            <i class="bi bi-eye-fill"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="bi bi-inbox-fill"></i>
            <h4>Tidak Ada Data</h4>
            <p>Belum ada serial number yang terdaftar. Serial number akan muncul setelah ada transaksi pembelian barang.</p>
        </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($serialNumbers->count() > 0)
<div class="pagination-wrap">
    {{ $serialNumbers->links() }}
</div>
@endif
@endsection
