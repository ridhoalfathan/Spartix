@extends('layouts.main')

@section('page-title', 'Data Produk')

@section('content')

<style>
    .container-product {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(30, 58, 138, 0.1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-header h2 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid rgba(30, 58, 138, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-icon.blue {
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
    }

    .stat-icon.green {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .stat-icon.orange {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .stat-card h4 {
        margin: 0;
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .value {
        font-size: 28px;
        font-weight: 700;
        color: #1e3a8a;
        margin: 5px 0 0 0;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
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

    .btn-primary {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .btn-sm {
        padding: 8px 14px;
        font-size: 13px;
        border-radius: 8px;
    }

    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .table-card {
        background: white;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .table-card h3 {
        margin: 0 0 20px 0;
        font-size: 22px;
        font-weight: 600;
        color: #1e3a8a;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: #1e293b;
    }

    table thead {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    }

    table th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    table th:first-child {
        border-top-left-radius: 10px;
    }

    table th:last-child {
        border-top-right-radius: 10px;
    }

    table td {
        padding: 16px;
        border-bottom: 1px solid rgba(30, 58, 138, 0.08);
        color: #334155;
        font-size: 14px;
    }

    table tbody tr {
        transition: all 0.2s;
        background: white;
    }

    table tbody tr:hover {
        background: rgba(30, 58, 138, 0.03);
        transform: scale(1.001);
    }

    .product-image-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 12px;
        background: rgba(30, 58, 138, 0.05);
        padding: 4px;
        border: 2px solid rgba(30, 58, 138, 0.1);
        transition: all 0.3s;
        cursor: pointer;
    }

    .product-image-thumbnail:hover {
        transform: scale(1.1);
        border-color: #2563eb;
    }

    .no-image-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(30, 58, 138, 0.05);
        border-radius: 12px;
        font-size: 30px;
        color: #94a3b8;
        border: 2px solid rgba(30, 58, 138, 0.1);
    }

    .stock-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .stock-number {
        font-weight: 700;
        font-size: 16px;
        color: #1e3a8a;
    }

    .stock-badge {
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        width: fit-content;
    }

    .stock-high {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .stock-medium {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .stock-low {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .price-tag {
        font-weight: 700;
        color: #1e3a8a;
        font-size: 15px;
    }

    .produksi-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: rgba(30, 58, 138, 0.08);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #1e3a8a;
        margin-top: 4px;
    }

    .produksi-count i {
        font-size: 14px;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 64px;
        opacity: 0.3;
        margin-bottom: 15px;
        display: block;
        color: #cbd5e1;
    }

    .empty-state h3 {
        font-size: 20px;
        margin: 15px 0 10px 0;
        color: #64748b;
    }

    .empty-state p {
        font-size: 14px;
        color: #94a3b8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-product {
            padding: 20px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            min-width: 1000px;
        }

        .actions {
            flex-direction: column;
            width: 100%;
        }

        .btn-sm {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-product">
    <div class="page-header">
        <h2>Data Produk</h2>
        <a href="{{ route('product.create') }}" class="btn btn-primary">
            <i class='bx bx-plus'></i> Tambah Produk
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">
                    <i class='bx bx-package'></i>
                </div>
                <h4>Total Produk</h4>
            </div>
            <p class="value">{{ number_format($products->count()) }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">
                    <i class='bx bx-cube'></i>
                </div>
                <h4>Total Stok</h4>
            </div>
            <p class="value">{{ number_format($products->sum('stock')) }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon orange">
                    <i class='bx bx-cog'></i>
                </div>
                <h4>Total Produksi</h4>
            </div>
            <p class="value">{{ number_format($products->sum('produksis_count')) }}</p>
        </div>
    </div>

    <div class="table-card">
        <h3>Daftar Produk</h3>
        
        @if($products->count() > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok Tersedia</th>
                        <th>Riwayat Produksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                    <tr>
                        <td><strong>{{ $key + 1 }}</strong></td>
                        <td>
                            @if($product->image)
                                @php
                                    // Handle both old and new image paths
                                    $imagePath = str_starts_with($product->image, 'storage/') 
                                        ? $product->image 
                                        : 'storage/' . $product->image;
                                @endphp
                                <img src="{{ asset($imagePath) }}" 
                                     alt="{{ $product->product_name }}" 
                                     class="product-image-thumbnail"
                                     onclick="window.open(this.src, '_blank')"
                                     onerror="this.parentElement.innerHTML='<div class=\'no-image-icon\'><i class=\'bx bx-image-alt\'></i></div>'">
                            @else
                                <div class="no-image-icon">
                                    <i class='bx bx-package'></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $product->product_name }}</strong></td>
                        <td>
                            <span class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <div class="stock-info">
                                <span class="stock-number">{{ number_format($product->stock) }} pcs</span>
                                @if($product->stock >= 500)
                                    <span class="stock-badge stock-high">
                                        <i class='bx bx-check-circle'></i> Stok Aman
                                    </span>
                                @elseif($product->stock >= 100)
                                    <span class="stock-badge stock-medium">
                                        <i class='bx bx-info-circle'></i> Stok Sedang
                                    </span>
                                @else
                                    <span class="stock-badge stock-low">
                                        <i class='bx bx-error-circle'></i> Stok Rendah
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($product->produksis_count > 0)
                                <span class="produksi-count">
                                    <i class='bx bx-history'></i>
                                    {{ $product->produksis_count }} kali produksi
                                </span>
                            @else
                                <span style="color: #94a3b8; font-size: 13px;">
                                    <i class='bx bx-info-circle'></i> Belum ada produksi
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('product.show', $product->id) }}" 
                                   class="btn btn-info btn-sm" 
                                   title="Lihat Detail & Riwayat Produksi">
                                    <i class='bx bx-show'></i>
                                </a>
                                <a href="{{ route('product.edit', $product->id) }}" 
                                   class="btn btn-warning btn-sm" 
                                   title="Edit Produk">
                                    <i class='bx bx-edit'></i>
                                </a>
                                <form action="{{ route('product.destroy', $product->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?\n\n{{ $product->produksis_count > 0 ? 'Produk ini memiliki ' . $product->produksis_count . ' riwayat produksi dan tidak bisa dihapus!' : '' }}')" 
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            title="Hapus Produk"
                                            @if($product->produksis_count > 0) disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class='bx bx-package'></i>
            <h3>Belum ada produk</h3>
            <p>Klik tombol "Tambah Produk" untuk menambahkan produk baru</p>
        </div>
        @endif
    </div>
</div>

@endsection