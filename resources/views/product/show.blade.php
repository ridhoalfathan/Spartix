@extends('layouts.main')

@section('page-title', 'Detail Produk')

@section('content')

<style>
    .detail-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(15px);
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        max-width: 900px;
        margin: 0 auto;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(255,255,255,0.2);
        flex-wrap: wrap;
        gap: 15px;
    }

    .detail-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .detail-header i {
        font-size: 32px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .detail-header h2 {
        margin: 0;
        font-size: 24px;
    }

    .detail-content {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .product-image-section {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .product-main-image {
        width: 100%;
        height: 300px;
        border-radius: 12px;
        background: rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 2px solid rgba(255,255,255,0.1);
    }

    .product-main-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .product-main-image.no-image {
        font-size: 100px;
        color: rgba(255,255,255,0.2);
    }

    .product-info-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-group {
        background: rgba(255,255,255,0.05);
        padding: 15px;
        border-radius: 10px;
        border-left: 4px solid #4facfe;
    }

    .info-label {
        font-size: 13px;
        opacity: 0.7;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 18px;
        font-weight: 600;
    }

    .stock-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stock-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
    }

    .stock-high {
        background: rgba(67, 233, 123, 0.2);
        color: #43e97b;
        border: 1px solid #43e97b;
    }

    .stock-medium {
        background: rgba(241, 196, 15, 0.2);
        color: #f1c40f;
        border: 1px solid #f1c40f;
    }

    .stock-low {
        background: rgba(255, 107, 107, 0.2);
        color: #ff6b6b;
        border: 1px solid #ff6b6b;
    }

    .detail-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        padding-top: 20px;
        border-top: 2px solid rgba(255,255,255,0.1);
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 30px;
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

    .btn-secondary {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.2);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(240, 147, 251, 0.6);
    }

    .btn-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(250, 112, 154, 0.4);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(250, 112, 154, 0.6);
    }

    .metadata {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 20px;
    }

    .metadata-item {
        background: rgba(255,255,255,0.05);
        padding: 12px;
        border-radius: 8px;
        font-size: 13px;
    }

    .metadata-item strong {
        display: block;
        opacity: 0.7;
        margin-bottom: 3px;
    }

    @media (max-width: 768px) {
        .detail-content {
            grid-template-columns: 1fr;
        }

        .detail-card {
            padding: 20px;
        }

        .detail-header h2 {
            font-size: 20px;
        }

        .detail-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .metadata {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="detail-card">
    <div class="detail-header">
        <div class="detail-header-left">
            <i class='bx bx-package'></i>
            <h2>Detail Produk</h2>
        </div>
        <a href="{{ route('product.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
    </div>

    <div class="detail-content">
        <!-- Product Image -->
        <div class="product-image-section">
            <div class="product-main-image {{ $product->image ? '' : 'no-image' }}">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->product_name }}">
                @else
                    <i class='bx bx-package'></i>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="product-info-section">
            <div class="info-group">
                <div class="info-label">Nama Produk</div>
                <div class="info-value">{{ $product->product_name }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Jumlah Stock</div>
                <div class="stock-info">
                    <div class="info-value">{{ number_format($product->stock) }} Unit</div>
                    @if($product->stock >= 500)
                        <span class="stock-badge stock-high">
                            <i class='bx bx-check-circle'></i> Stock Aman
                        </span>
                    @elseif($product->stock >= 100)
                        <span class="stock-badge stock-medium">
                            <i class='bx bx-error'></i> Stock Sedang
                        </span>
                    @else
                        <span class="stock-badge stock-low">
                            <i class='bx bx-error-circle'></i> Stock Rendah
                        </span>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="metadata">
                <div class="metadata-item">
                    <strong>Dibuat Pada:</strong>
                    {{ $product->created_at->format('d M Y, H:i') }}
                </div>
                <div class="metadata-item">
                    <strong>Terakhir Update:</strong>
                    {{ $product->updated_at->format('d M Y, H:i') }}
                </div>
            </div>
        </div>
    </div>

    <div class="detail-actions">
        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning">
            <i class='bx bx-edit'></i> Edit Produk
        </a>
        <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class='bx bx-trash'></i> Hapus Produk
            </button>
        </form>
    </div>
</div>

@endsection