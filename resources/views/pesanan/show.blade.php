@extends('layouts.main')

@section('page-title', 'Detail Pesanan')

@section('content')

<style>
    .detail-card {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        max-width: 800px;
        margin: 0 auto;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(30, 58, 138, 0.1);
    }

    .detail-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .detail-header i {
        font-size: 32px;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .detail-header h2 {
        margin: 0;
        font-size: 24px;
        color: #1e3a8a;
        font-weight: 700;
    }

    .detail-content {
        display: grid;
        gap: 20px;
    }

    .detail-item {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 20px;
        padding: 15px;
        background: rgba(30, 58, 138, 0.02);
        border-radius: 8px;
        border-left: 4px solid #2563eb;
    }

    .detail-label {
        font-weight: 600;
        color: #1e3a8a;
        font-size: 14px;
    }

    .detail-value {
        color: #334155;
        font-size: 14px;
    }

    .detail-value strong {
        color: #1e3a8a;
        font-size: 16px;
    }

    .status-badge {
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .status-complete {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .product-detail {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .product-name {
        font-weight: 600;
        color: #1e3a8a;
        font-size: 16px;
    }

    .product-stock {
        font-size: 13px;
        color: #64748b;
    }

    .detail-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
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
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .btn-secondary {
        background: white;
        color: #1e3a8a;
        border: 2px solid rgba(30, 58, 138, 0.3);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
        .detail-item {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .detail-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="detail-card">
    <div class="detail-header">
        <div class="detail-header-left">
            <i class='bx bx-receipt'></i>
            <h2>Detail Pesanan</h2>
        </div>
        <a href="{{ route('pesanan.edit', $pesanan->id) }}" class="btn btn-warning">
            <i class='bx bx-edit'></i> Edit
        </a>
    </div>

    <div class="detail-content">
        <div class="detail-item">
            <div class="detail-label">ID Pesanan</div>
            <div class="detail-value"><strong>{{ $pesanan->id_pesanan }}</strong></div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Nama Pemesan</div>
            <div class="detail-value"><strong>{{ $pesanan->nama_pemesan }}</strong></div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Nama Produk</div>
            <div class="detail-value">
                <div class="product-detail">
                    <span class="product-name">{{ $pesanan->product->product_name }}</span>
                    <span class="product-stock">Stock Tersedia: {{ number_format($pesanan->product->stock) }}</span>
                </div>
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Jumlah Pesanan</div>
            <div class="detail-value"><strong>{{ number_format($pesanan->jumlah_pesanan) }} Pcs</strong></div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Tanggal Pembayaran</div>
            <div class="detail-value">{{ $pesanan->tanggal_pembayaran->format('d F Y') }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Status</div>
            <div class="detail-value">
                <span class="status-badge {{ $pesanan->status == 'Complete' ? 'status-complete' : 'status-pending' }}">
                    {{ $pesanan->status }}
                </span>
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Dibuat Pada</div>
            <div class="detail-value">{{ $pesanan->created_at->format('d F Y, H:i') }} WIB</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Terakhir Update</div>
            <div class="detail-value">{{ $pesanan->updated_at->format('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <div class="detail-actions">
        <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
        <a href="{{ route('pesanan.edit', $pesanan->id) }}" class="btn btn-warning">
            <i class='bx bx-edit'></i> Edit Pesanan
        </a>
    </div>
</div>

@endsection