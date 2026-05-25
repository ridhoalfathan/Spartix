@extends('layouts.main')

@section('title', 'Detail Serial Number - RAYA-E')

@section('styles')
<style>
    .page-header {
        background: #ffffff;
        padding: 1.75rem 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
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
        letter-spacing: -0.5px;
    }
    
    .page-title i {
        color: #2563EB;
        font-size: 2rem;
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
        cursor: pointer;
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
        background: #ffffff;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
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
        letter-spacing: -0.5px;
    }
    
    .card-title i {
        color: #2563EB;
        font-size: 1.5rem;
    }
    
    .serial-display {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(30, 64, 175, 0.1) 100%);
        padding: 2.5rem;
        border-radius: 16px;
        text-align: center;
        margin-bottom: 2rem;
        border: 3px solid #2563EB;
    }
    
    .serial-label {
        font-size: 0.85rem;
        color: #2563EB;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 1rem;
    }
    
    .serial-code {
        font-family: 'Courier New', monospace;
        font-size: 2.5rem;
        font-weight: 900;
        color: #1e3a8a;
        letter-spacing: 3px;
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
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .detail-value {
        font-size: 1.1rem;
        color: #1e3a8a;
        font-weight: 800;
    }
    
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
    }
    
    .badge-success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
        color: #059669;
        border: 2px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge-secondary {
        background: linear-gradient(135deg, rgba(100, 116, 139, 0.15) 0%, rgba(71, 85, 105, 0.15) 100%);
        color: #475569;
        border: 2px solid rgba(100, 116, 139, 0.3);
    }
    
    .badge-category {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.85rem;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(30, 64, 175, 0.15) 100%);
        color: #1e40af;
        border: 2px solid rgba(37, 99, 235, 0.2);
    }
    
    .info-box {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
        color: #1e3a8a;
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        border-left: 4px solid #f59e0b;
        margin-bottom: 2rem;
        display: flex;
        align-items: start;
        gap: 0.875rem;
        font-weight: 600;
    }
    
    .info-box i {
        font-size: 1.5rem;
        color: #f59e0b;
        margin-top: 0.125rem;
    }
    
    .timeline {
        position: relative;
        padding-left: 2.5rem;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #2563EB 0%, #1e40af 100%);
        border-radius: 2px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        padding-left: 1.5rem;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -2rem;
        top: 0.25rem;
        width: 14px;
        height: 14px;
        background: #2563EB;
        border-radius: 50%;
        border: 4px solid #ffffff;
        box-shadow: 0 0 0 3px #2563EB;
        z-index: 1;
    }
    
    .timeline-date {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .timeline-content {
        background: rgba(37, 99, 235, 0.05);
        padding: 1.25rem;
        border-radius: 12px;
        border-left: 3px solid #2563EB;
    }
    
    .timeline-title {
        font-weight: 800;
        color: #1e3a8a;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1rem;
    }
    
    .timeline-title i {
        color: #2563EB;
    }
    
    .timeline-desc {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.8;
        font-weight: 600;
    }
    
    .timeline-desc strong {
        color: #1e3a8a;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: #2563EB;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
        .detail-row {
            grid-template-columns: 1fr;
        }
        
        .serial-code {
            font-size: 1.75rem;
            letter-spacing: 2px;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-upc-scan"></i>
        Detail Serial Number
    </h1>
    <a href="{{ route('serial-numbers.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle-fill"></i>
        Kembali
    </a>
</div>

<!-- Serial Number Display -->
<div class="serial-display">
    <div class="serial-label">🔢 Serial Number</div>
    <div class="serial-code">{{ $serialNumber->serial_number }}</div>
</div>

<!-- Informasi Serial Number -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-info-circle-fill"></i>
            Informasi Serial Number
        </h3>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Status</span>
            <div>
                @if($serialNumber->status == 'READY')
                    <span class="badge badge-success">
                        <i class="bi bi-check-circle-fill"></i> READY
                    </span>
                @else
                    <span class="badge badge-secondary">
                        <i class="bi bi-x-circle-fill"></i> TERJUAL
                    </span>
                @endif
            </div>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Harga Beli (HPP)</span>
            <span class="detail-value" style="color: #10b981;">Rp {{ number_format($serialNumber->harga_beli, 0, ',', '.') }}</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Tanggal Masuk</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($serialNumber->tanggal_masuk)->format('d F Y') }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Tanggal Keluar</span>
            <span class="detail-value">
                @if($serialNumber->tanggal_keluar)
                    {{ \Carbon\Carbon::parse($serialNumber->tanggal_keluar)->format('d F Y') }}
                @else
                    <span style="color: #94a3b8;">Belum Terjual</span>
                @endif
            </span>
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
            <span class="detail-value" style="color: #2563EB;">{{ $serialNumber->barang->kode_barang }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Nama Barang</span>
            <span class="detail-value">{{ $serialNumber->barang->nama_barang }}</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Kategori</span>
            <div>
                <span class="badge-category">
                    {{ $serialNumber->barang->kategori }}
                </span>
            </div>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Merk</span>
            <span class="detail-value">{{ $serialNumber->barang->merk }}</span>
        </div>
    </div>
</div>

<!-- Timeline / Riwayat -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-clock-history"></i>
            Timeline / Riwayat
        </h3>
    </div>
    
    <div class="timeline">
        <!-- Barang Masuk -->
        <div class="timeline-item">
            <div class="timeline-date">
                <i class="bi bi-calendar-check-fill"></i> {{ \Carbon\Carbon::parse($serialNumber->tanggal_masuk)->format('d F Y, H:i') }}
            </div>
            <div class="timeline-content">
                <div class="timeline-title">
                    <i class="bi bi-cart-plus-fill"></i> Pembelian Barang
                </div>
                <div class="timeline-desc">
                    <strong>No. Transaksi:</strong> {{ $serialNumber->barangMasuk->nomor_transaksi }}<br>
                    <strong>Supplier:</strong> {{ $serialNumber->barangMasuk->supplier ?? '-' }}<br>
                    <strong>Harga Beli:</strong> Rp {{ number_format($serialNumber->harga_beli, 0, ',', '.') }}
                </div>
            </div>
        </div>
        
        <!-- Barang Keluar (jika ada) -->
        @if($serialNumber->status == 'TERJUAL' && $serialNumber->barangKeluar)
        <div class="timeline-item">
            <div class="timeline-date">
                <i class="bi bi-calendar-check-fill"></i> {{ \Carbon\Carbon::parse($serialNumber->barangKeluar->tanggal_keluar)->format('d F Y, H:i') }}
            </div>
            <div class="timeline-content">
                <div class="timeline-title">
                    <i class="bi bi-cash-coin"></i> Penjualan Barang
                </div>
                <div class="timeline-desc">
                    <strong>No. Transaksi:</strong> {{ $serialNumber->barangKeluar->nomor_transaksi }}<br>
                    <strong>Customer:</strong> {{ $serialNumber->barangKeluar->customer ?? '-' }}<br>
                    <strong>HPP:</strong> Rp {{ number_format($serialNumber->barangKeluar->hpp, 0, ',', '.') }}<br>
                    <strong>Harga Jual:</strong> <span style="color: #10b981; font-weight: 800;">Rp {{ number_format($serialNumber->barangKeluar->harga_jual, 0, ',', '.') }}</span><br>
                    <strong>Laba:</strong> <span style="color: {{ $serialNumber->barangKeluar->laba >= 0 ? '#10b981' : '#ef4444' }}; font-weight: 800;">
                        Rp {{ number_format($serialNumber->barangKeluar->laba, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
        @else
        <div class="timeline-item">
            <div class="timeline-date">
                <i class="bi bi-hourglass-split"></i> Menunggu
            </div>
            <div class="timeline-content">
                <div class="timeline-title">
                    <i class="bi bi-clock-fill"></i> Status: Ready untuk Dijual
                </div>
                <div class="timeline-desc">
                    Serial number ini masih tersedia dan siap untuk dijual.
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@if($serialNumber->status == 'READY')
<div class="info-box">
    <i class="bi bi-info-circle-fill"></i>
    <div>
        <strong>Info:</strong> Serial number ini masih dalam status READY. Untuk menjual barang ini, gunakan menu <strong>Penjualan Barang</strong>.
    </div>
</div>
@endif
@endsection