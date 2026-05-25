@extends('layouts.main')

@section('title', 'Detail Penjualan - RAYA-E')

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
        color: #f59e0b;
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
        color: #f59e0b;
    }
    
    .transaction-display {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        padding: 2rem;
        border-radius: 16px;
        text-align: center;
        margin-bottom: 2rem;
        border: 2px solid #f59e0b;
    }
    
    .transaction-label {
        font-size: 0.85rem;
        color: #92400e;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
    }
    
    .transaction-code {
        font-family: 'Courier New', monospace;
        font-size: 2rem;
        font-weight: 900;
        color: #78350f;
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
    
    .serial-display {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        border: 2px solid #2563EB;
    }
    
    .serial-label {
        font-size: 0.85rem;
        color: #1e40af;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
    }
    
    .serial-code {
        font-family: 'Courier New', monospace;
        font-size: 1.75rem;
        font-weight: 900;
        color: #1e3a8a;
        letter-spacing: 2px;
    }
    
    .calculation-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
    }
    
    .calc-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .calc-item:last-child {
        border-bottom: none;
        border-top: 2px solid #2563EB;
        padding-top: 1.25rem;
        margin-top: 0.5rem;
    }
    
    .calc-label {
        font-weight: 600;
        color: #475569;
    }
    
    .calc-value {
        font-weight: 800;
        color: #1e3a8a;
        font-size: 1.1rem;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
        }
        
        .detail-row {
            grid-template-columns: 1fr;
        }
        
        .transaction-code, .serial-code {
            font-size: 1.25rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-box-arrow-up-fill"></i>
        Detail Penjualan
    </h1>
    <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<!-- Transaction Display -->
<div class="transaction-display">
    <div class="transaction-label">Nomor Transaksi</div>
    <div class="transaction-code">{{ $barangKeluar->nomor_transaksi }}</div>
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
            <span class="detail-label">Tanggal Keluar</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->format('d F Y') }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Customer</span>
            <span class="detail-value">{{ $barangKeluar->customer ?? '-' }}</span>
        </div>
    </div>
    
    <div class="detail-item" style="margin-top: 1rem;">
        <span class="detail-label">Keterangan</span>
        <span class="detail-value" style="font-weight: 500;">{{ $barangKeluar->keterangan ?? '-' }}</span>
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
            <span class="detail-value">{{ $barangKeluar->barang->kode_barang }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Nama Barang</span>
            <span class="detail-value">{{ $barangKeluar->barang->nama_barang }}</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Kategori</span>
            <div>
                <span class="badge-category badge-{{ strtolower($barangKeluar->barang->kategori) }}">
                    {{ $barangKeluar->barang->kategori }}
                </span>
            </div>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Merk</span>
            <span class="detail-value">{{ $barangKeluar->barang->merk }}</span>
        </div>
    </div>
</div>

<!-- Serial Number -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-upc-scan"></i>
            Serial Number
        </h3>
    </div>
    
    <div class="serial-display">
        <div class="serial-label">Serial Number</div>
        <div class="serial-code">{{ $barangKeluar->serialNumber->serial_number }}</div>
    </div>
</div>

<!-- Perhitungan -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-calculator"></i>
            Perhitungan Penjualan
        </h3>
    </div>
    
    <div class="calculation-card">
        <div class="calc-item">
            <span class="calc-label">HPP (Harga Pokok Penjualan):</span>
            <span class="calc-value">Rp {{ number_format($barangKeluar->hpp, 0, ',', '.') }}</span>
        </div>
        
        <div class="calc-item">
            <span class="calc-label">Harga Jual:</span>
            <span class="calc-value">Rp {{ number_format($barangKeluar->harga_jual, 0, ',', '.') }}</span>
        </div>
        
        <div class="calc-item">
            <span class="calc-label">Laba / Rugi:</span>
            <span class="calc-value" style="color: {{ $barangKeluar->laba >= 0 ? '#22c55e' : '#ef4444' }}; font-size: 1.5rem;">
                {{ $barangKeluar->laba >= 0 ? '+' : '' }} Rp {{ number_format($barangKeluar->laba, 0, ',', '.') }}
            </span>
        </div>
    </div>
    
    @if($barangKeluar->laba >= 0)
    <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; padding: 1rem 1.25rem; border-radius: 10px; margin-top: 1.5rem; border-left: 4px solid #22c55e;">
        <i class="bi bi-graph-up-arrow"></i>
        <strong>Profit:</strong> Transaksi ini menghasilkan keuntungan sebesar Rp {{ number_format($barangKeluar->laba, 0, ',', '.') }}
    </div>
    @else
    <div style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #991b1b; padding: 1rem 1.25rem; border-radius: 10px; margin-top: 1.5rem; border-left: 4px solid #ef4444;">
        <i class="bi bi-graph-down-arrow"></i>
        <strong>Loss:</strong> Transaksi ini mengalami kerugian sebesar Rp {{ number_format(abs($barangKeluar->laba), 0, ',', '.') }}
    </div>
    @endif
</div>
@endsection