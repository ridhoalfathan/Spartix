@extends('layouts.main')

@section('title', 'Detail Barang Masuk - RAYA-E')

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
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-secondary {
        background: #94a3b8;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #64748b;
        transform: translateY(-2px);
        color: white;
    }
    
    .detail-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }
    
    .card-header-custom {
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }
    
    .card-title i {
        color: #22c55e;
    }
    
    .transaction-display {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        padding: 2rem;
        border-radius: 16px;
        text-align: center;
        margin-bottom: 2rem;
        border: 2px solid #22c55e;
    }
    
    .transaction-label {
        font-size: 0.85rem;
        color: #065f46;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
    }
    
    .transaction-code {
        font-family: 'Courier New', monospace;
        font-size: 2rem;
        font-weight: 900;
        color: #166534;
        letter-spacing: 2px;
    }
    
    .detail-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .detail-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .detail-value {
        font-size: 1.1rem;
        color: #1e3a8a;
        font-weight: 700;
    }
    
    .badge-category {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
    }
    
    .badge-tv {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }
    
    .badge-ac {
        background: linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%);
        color: #5b21b6;
    }
    
    .badge-kulkas {
        background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
        color: #9f1239;
    }
    
    .table {
        margin: 0;
    }
    
    .table thead {
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        color: white;
    }
    
    .table thead th {
        padding: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table tbody tr:hover {
        background: rgba(34, 197, 94, 0.05);
    }
    
    .serial-code {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: #2563EB;
        background: rgba(37, 99, 235, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        display: inline-block;
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
    
    .badge-secondary {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #475569;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
        }
        
        .detail-row {
            grid-template-columns: 1fr;
        }
        
        .transaction-code {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-box-arrow-in-down-fill"></i>
        Detail Barang Masuk
    </h1>
    <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<!-- Transaction Display -->
<div class="transaction-display">
    <div class="transaction-label">Nomor Transaksi</div>
    <div class="transaction-code">{{ $barangMasuk->nomor_transaksi }}</div>
</div>

<!-- Informasi Transaksi -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-receipt"></i>
            Informasi Transaksi
        </h3>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Tanggal Masuk</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d F Y') }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Supplier</span>
            <span class="detail-value">{{ $barangMasuk->supplier ?? '-' }}</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Jumlah</span>
            <span class="detail-value">{{ $barangMasuk->jumlah }} Unit</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Harga Beli (per unit)</span>
            <span class="detail-value">Rp {{ number_format($barangMasuk->harga_beli, 0, ',', '.') }}</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Total Harga</span>
            <span class="detail-value" style="color: #22c55e;">Rp {{ number_format($barangMasuk->total_harga, 0, ',', '.') }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Keterangan</span>
            <span class="detail-value" style="font-weight: 500;">{{ $barangMasuk->keterangan ?? '-' }}</span>
        </div>
    </div>
</div>

<!-- Informasi Barang -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-box-seam-fill"></i>
            Informasi Barang
        </h3>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Kode Barang</span>
            <span class="detail-value">{{ $barangMasuk->barang->kode_barang }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Nama Barang</span>
            <span class="detail-value">{{ $barangMasuk->barang->nama_barang }}</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Kategori</span>
            <div>
                <span class="badge-category badge-{{ strtolower($barangMasuk->barang->kategori) }}">
                    {{ $barangMasuk->barang->kategori }}
                </span>
            </div>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Merk</span>
            <span class="detail-value">{{ $barangMasuk->barang->merk }}</span>
        </div>
    </div>
</div>

<!-- Daftar Serial Numbers -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-upc-scan"></i>
            Daftar Serial Number ({{ $barangMasuk->serialNumbers->count() }})
        </h3>
    </div>
    
    @if($barangMasuk->serialNumbers->count() > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>SERIAL NUMBER</th>
                    <th>HARGA BELI</th>
                    <th>TANGGAL MASUK</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangMasuk->serialNumbers as $index => $sn)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="serial-code">{{ $sn->serial_number }}</span>
                    </td>
                    <td>Rp {{ number_format($sn->harga_beli, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($sn->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td>
                        @if($sn->status == 'READY')
                            <span class="badge badge-success">
                                <i class="bi bi-check-circle"></i> READY
                            </span>
                        @else
                            <span class="badge badge-secondary">
                                <i class="bi bi-x-circle"></i> TERJUAL
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; padding: 2rem; color: #64748b;">
        <i class="bi bi-inbox" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
        <p>Tidak ada serial number</p>
    </div>
    @endif
</div>
@endsection