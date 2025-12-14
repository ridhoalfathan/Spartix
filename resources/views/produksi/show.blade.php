@extends('layouts.main')

@section('page-title', 'Detail Produksi')

@section('content')

<style>
    .container-detail {
        max-width: 1000px;
        margin: 0 auto;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: white;
        color: #1e3a8a;
        border: 2px solid rgba(30, 58, 138, 0.2);
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 20px;
        transition: all 0.3s;
    }

    .back-button:hover {
        background: rgba(30, 58, 138, 0.05);
        border-color: #1e3a8a;
        transform: translateX(-5px);
    }

    .detail-card {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(30, 58, 138, 0.1);
        margin-bottom: 25px;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(30, 58, 138, 0.1);
    }

    .detail-header-left h1 {
        margin: 0 0 10px 0;
        font-size: 28px;
        font-weight: 700;
        color: #1e3a8a;
    }

    .detail-header-left p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .status-badge {
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-selesai {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 2px solid rgba(16, 185, 129, 0.3);
    }

    .status-belum {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 2px solid rgba(239, 68, 68, 0.3);
    }

    .status-sedang {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
        border: 2px solid rgba(59, 130, 246, 0.3);
    }

    .status-dibatalkan {
        background: rgba(156, 163, 175, 0.15);
        color: #6b7280;
        border: 2px solid rgba(156, 163, 175, 0.3);
    }

    .status-proses {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 2px solid rgba(245, 158, 11, 0.3);
    }

    .status-menunggu {
        background: rgba(249, 115, 22, 0.15);
        color: #ea580c;
        border: 2px solid rgba(249, 115, 22, 0.3);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .detail-item {
        background: rgba(30, 58, 138, 0.02);
        padding: 20px;
        border-radius: 12px;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .detail-item-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .detail-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .detail-icon.blue {
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
    }

    .detail-icon.green {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .detail-icon.purple {
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
    }

    .detail-icon.orange {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .detail-item label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .detail-item .value {
        font-size: 18px;
        font-weight: 700;
        color: #1e3a8a;
        margin-top: 8px;
    }

    .detail-item .sub-value {
        font-size: 13px;
        color: #64748b;
        margin-top: 5px;
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .product-info-card {
        background: linear-gradient(135deg, rgba(30, 58, 138, 0.05), rgba(37, 99, 235, 0.05));
        border: 2px solid rgba(30, 58, 138, 0.2);
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .product-info-card h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        font-weight: 600;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-info-card h3 i {
        font-size: 22px;
    }

    .product-details {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .product-detail-item {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .product-detail-item label {
        display: block;
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .product-detail-item .value {
        font-size: 16px;
        font-weight: 700;
        color: #1e3a8a;
    }

    .keterangan-box {
        background: rgba(59, 130, 246, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.2);
        padding: 20px;
        border-radius: 12px;
        margin-top: 25px;
    }

    .keterangan-box h4 {
        margin: 0 0 10px 0;
        font-size: 14px;
        font-weight: 600;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .keterangan-box p {
        margin: 0;
        color: #334155;
        line-height: 1.6;
        font-size: 14px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        padding-top: 25px;
        border-top: 2px solid rgba(30, 58, 138, 0.1);
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .timeline {
        background: white;
        padding: 25px;
        border-radius: 12px;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .timeline h3 {
        margin: 0 0 20px 0;
        font-size: 18px;
        font-weight: 600;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .timeline-item {
        display: flex;
        gap: 15px;
        padding: 15px;
        background: rgba(30, 58, 138, 0.02);
        border-radius: 8px;
        border-left: 3px solid #2563eb;
        margin-bottom: 10px;
    }

    .timeline-item i {
        font-size: 20px;
        color: #2563eb;
    }

    .timeline-item-content {
        flex: 1;
    }

    .timeline-item-content h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        font-weight: 600;
        color: #1e3a8a;
    }

    .timeline-item-content p {
        margin: 0;
        font-size: 13px;
        color: #64748b;
    }

    @media (max-width: 768px) {
        .detail-card {
            padding: 20px;
        }

        .detail-header {
            flex-direction: column;
            gap: 15px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .product-details {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-detail">
    <a href="{{ route('produksi.index') }}" class="back-button">
        <i class='bx bx-arrow-back'></i> Kembali ke Daftar Produksi
    </a>

    <!-- Main Detail Card -->
    <div class="detail-card">
        <div class="detail-header">
            <div class="detail-header-left">
                <h1>Detail Produksi</h1>
                <p>Informasi lengkap data produksi</p>
            </div>
            <div>
                @php
                    $statusClass = match($produksi->status) {
                        'Selesai' => 'selesai',
                        'Belum Diproses' => 'belum',
                        'Sedang Diproses' => 'sedang',
                        'Dibatalkan' => 'dibatalkan',
                        'Proses' => 'proses',
                        'Menunggu Bahan' => 'menunggu',
                        default => 'proses'
                    };
                @endphp
                <span class="status-badge status-{{ $statusClass }}">
                    {{ $produksi->status }}
                </span>
            </div>
        </div>

        <!-- Product Information -->
        <div class="product-info-card">
            <h3>
                <i class='bx bx-package'></i>
                Informasi Produk
            </h3>
            <div class="product-details">
                <div class="product-detail-item">
                    <label>Nama Produk</label>
                    <div class="value">{{ $produksi->product->product_name }}</div>
                </div>
                <div class="product-detail-item">
                    <label>Harga Satuan</label>
                    <div class="value" style="color: #059669;">Rp {{ number_format($produksi->product->price, 0, ',', '.') }}</div>
                </div>
                <div class="product-detail-item">
                    <label>Stok Saat Ini</label>
                    <div class="value">{{ number_format($produksi->product->stock) }} pcs</div>
                </div>
            </div>
        </div>

        <!-- Production Details -->
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-item-header">
                    <div class="detail-icon blue">
                        <i class='bx bx-user'></i>
                    </div>
                    <label>Karyawan</label>
                </div>
                <div class="value">{{ $produksi->karyawan->nama_karyawan }}</div>
                <div class="sub-value">{{ $produksi->karyawan->jabatan }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-item-header">
                    <div class="detail-icon green">
                        <i class='bx bx-package'></i>
                    </div>
                    <label>Jumlah Produksi</label>
                </div>
                <div class="value">{{ number_format($produksi->quantity) }} pcs</div>
                @if($produksi->status === 'Selesai')
                    <div class="sub-value">✓ Sudah ditambahkan ke stok</div>
                @else
                    <div class="sub-value">Belum ditambahkan ke stok</div>
                @endif
            </div>

            <div class="detail-item">
                <div class="detail-item-header">
                    <div class="detail-icon purple">
                        <i class='bx bx-calendar'></i>
                    </div>
                    <label>Tanggal Produksi</label>
                </div>
                <div class="value">{{ $produksi->tanggal->format('d F Y') }}</div>
                <div class="sub-value">{{ $produksi->tanggal->diffForHumans() }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-item-header">
                    <div class="detail-icon orange">
                        <i class='bx bx-time'></i>
                    </div>
                    <label>Waktu Produksi</label>
                </div>
                <div class="value">{{ \Carbon\Carbon::parse($produksi->waktu)->format('H:i') }} WIB</div>
                <div class="sub-value">{{ \Carbon\Carbon::parse($produksi->waktu)->format('h:i A') }}</div>
            </div>
        </div>

        @if($produksi->keterangan)
        <div class="keterangan-box">
            <h4>
                <i class='bx bx-note'></i>
                Keterangan
            </h4>
            <p>{{ $produksi->keterangan }}</p>
        </div>
        @endif

        <div class="action-buttons">
            <a href="{{ route('produksi.edit', $produksi->id) }}" class="btn btn-warning">
                <i class='bx bx-edit'></i> Edit Produksi
            </a>
            <form action="{{ route('produksi.destroy', $produksi->id) }}" method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus data produksi ini?\n\n{{ $produksi->status === 'Selesai' ? 'Perhatian: Stok produk akan dikurangi!' : '' }}')" 
                  style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class='bx bx-trash'></i> Hapus Produksi
                </button>
            </form>
        </div>
    </div>

    <!-- Timeline -->
    <div class="timeline">
        <h3>
            <i class='bx bx-time-five'></i>
            Timeline
        </h3>
        
        <div class="timeline-item">
            <i class='bx bx-plus-circle'></i>
            <div class="timeline-item-content">
                <h4>Produksi Dibuat</h4>
                <p>{{ $produksi->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        @if($produksi->created_at != $produksi->updated_at)
        <div class="timeline-item">
            <i class='bx bx-edit'></i>
            <div class="timeline-item-content">
                <h4>Terakhir Diupdate</h4>
                <p>{{ $produksi->updated_at->format('d F Y, H:i') }} WIB ({{ $produksi->updated_at->diffForHumans() }})</p>
            </div>
        </div>
        @endif

        @if($produksi->status === 'Selesai')
        <div class="timeline-item" style="border-left-color: #10b981;">
            <i class='bx bx-check-circle' style="color: #10b981;"></i>
            <div class="timeline-item-content">
                <h4>Produksi Selesai</h4>
                <p>Stok produk telah ditambahkan sebanyak {{ number_format($produksi->quantity) }} unit</p>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection