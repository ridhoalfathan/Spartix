@extends('layouts.main')

@section('title', 'Detail Barang - RAYA-E')

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
    
    .btn-group-header {
        display: flex;
        gap: 0.75rem;
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
    
    .btn-primary {
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        color: white;
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
    
    .badge-warning {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
        color: #d97706;
        border: 2px solid rgba(245, 158, 11, 0.3);
    }
    
    .badge-danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
        color: #dc2626;
        border: 2px solid rgba(239, 68, 68, 0.3);
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
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 600;
        color: #1e3a8a;
    }
    
    .table tbody tr:hover {
        background: rgba(37, 99, 235, 0.05);
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
    
    .empty-state h5 {
        color: #1e3a8a;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 500;
    }
    
    .table-info {
        padding: 1rem;
        text-align: center;
        color: #64748b;
        font-size: 0.9rem;
        background: rgba(37, 99, 235, 0.05);
        border-radius: 0 0 16px 16px;
        font-weight: 600;
    }
    
    .table-info i {
        color: #2563EB;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
        .btn-group-header {
            width: 100%;
        }
        
        .btn {
            flex: 1;
            justify-content: center;
        }
        
        .detail-row {
            grid-template-columns: 1fr;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-info-circle-fill"></i>
        Detail Barang
    </h1>
    <div class="btn-group-header">
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle-fill"></i>
            Kembali
        </a>
        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil-fill"></i>
            Edit
        </a>
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
            <span class="detail-value" style="color: #2563EB;">{{ $barang->kode_barang }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Nama Barang</span>
            <span class="detail-value">{{ $barang->nama_barang }}</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Kategori</span>
            <div>
                <span class="badge-category">
                    {{ $barang->kategori }}
                </span>
            </div>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Merk</span>
            <span class="detail-value">{{ $barang->merk }}</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Harga Barang</span>
            <span class="detail-value" style="color: #10b981;">{{ $barang->harga_format }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Stok Tersedia</span>
            <span class="detail-value">{{ $barang->stok }} Unit</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Status Stok</span>
            <div>
                @if($barang->stok <= 0)
                    <span class="badge badge-danger">
                        <i class="bi bi-x-circle-fill"></i> Habis
                    </span>
                @elseif($barang->stok <= $barang->stok_minimum)
                    <span class="badge badge-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i> Rendah
                    </span>
                @else
                    <span class="badge badge-success">
                        <i class="bi bi-check-circle-fill"></i> Normal
                    </span>
                @endif
            </div>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Stok Minimum</span>
            <span class="detail-value">{{ $barang->stok_minimum }} Unit</span>
        </div>
    </div>
    
    <div class="detail-row">
        <div class="detail-item">
            <span class="detail-label">Metode</span>
            <span class="detail-value">{{ $barang->metode }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Ditambahkan Pada</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($barang->created_at)->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    
    @if($barang->deskripsi)
    <div class="detail-item" style="margin-top: 1rem;">
        <span class="detail-label">Deskripsi</span>
        <span class="detail-value" style="font-weight: 600; line-height: 1.6;">{{ $barang->deskripsi }}</span>
    </div>
    @endif
</div>

<!-- Riwayat Barang Masuk -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-cart-plus-fill"></i>
            Riwayat Pembelian (5 Terakhir)
        </h3>
    </div>
    
    @if($barang->barangMasuk && $barang->barangMasuk->count() > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>NO TRANSAKSI</th>
                    <th>TANGGAL</th>
                    <th>JUMLAH</th>
                    <th>HARGA BELI</th>
                    <th>SUPPLIER</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang->barangMasuk->take(5) as $masuk)
                <tr>
                    <td><strong style="color: #2563EB;">{{ $masuk->nomor_transaksi }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($masuk->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td><strong>{{ $masuk->jumlah }}</strong> Unit</td>
                    <td style="color: #10b981; font-weight: 700;">Rp {{ number_format($masuk->harga_beli, 0, ',', '.') }}</td>
                    <td>{{ $masuk->supplier ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="bi bi-inbox-fill"></i>
        <h5>Belum Ada Data</h5>
        <p>Belum ada riwayat pembelian barang</p>
    </div>
    @endif
</div>

<!-- Riwayat Barang Keluar -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-cash-coin"></i>
            Riwayat Penjualan (5 Terakhir)
        </h3>
    </div>
    
    @if($barang->barangKeluar && $barang->barangKeluar->count() > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>NO TRANSAKSI</th>
                    <th>TANGGAL</th>
                    <th>SERIAL NUMBER</th>
                    <th>HPP</th>
                    <th>HARGA JUAL</th>
                    <th>LABA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang->barangKeluar->take(5) as $keluar)
                <tr>
                    <td><strong style="color: #2563EB;">{{ $keluar->nomor_transaksi }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($keluar->tanggal_keluar)->format('d/m/Y') }}</td>
                    <td><strong>{{ $keluar->serialNumber->serial_number ?? '-' }}</strong></td>
                    <td style="color: #ef4444; font-weight: 700;">Rp {{ number_format($keluar->hpp, 0, ',', '.') }}</td>
                    <td style="color: #10b981; font-weight: 700;">Rp {{ number_format($keluar->harga_jual, 0, ',', '.') }}</td>
                    <td style="color: {{ $keluar->laba >= 0 ? '#10b981' : '#ef4444' }}; font-weight: 800;">
                        Rp {{ number_format($keluar->laba, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="bi bi-inbox-fill"></i>
        <h5>Belum Ada Data</h5>
        <p>Belum ada riwayat penjualan barang</p>
    </div>
    @endif
</div>

<!-- Serial Numbers -->
<div class="detail-card">
    <div class="card-header-custom">
        <h3 class="card-title">
            <i class="bi bi-upc-scan"></i>
            Serial Numbers Tersedia
        </h3>
    </div>
    
    @if($barang->serialNumbers && $barang->serialNumbers->where('status', 'READY')->count() > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>SERIAL NUMBER</th>
                    <th>TANGGAL MASUK</th>
                    <th>HARGA BELI</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang->serialNumbers->where('status', 'READY')->take(10) as $index => $serial)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td><strong style="color: #2563EB;">{{ $serial->serial_number }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($serial->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td style="color: #10b981; font-weight: 700;">Rp {{ number_format($serial->harga_beli, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-success">
                            <i class="bi bi-check-circle-fill"></i> Tersedia
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($barang->serialNumbers->where('status', 'READY')->count() > 10)
        <div class="table-info">
            <i class="bi bi-info-circle-fill"></i>
            Menampilkan 10 dari {{ $barang->serialNumbers->where('status', 'READY')->count() }} serial number tersedia
        </div>
        @endif
    </div>
    @else
    <div class="empty-state">
        <i class="bi bi-inbox-fill"></i>
        <h5>Belum Ada Data</h5>
        <p>Belum ada serial number tersedia</p>
    </div>
    @endif
</div>
@endsection