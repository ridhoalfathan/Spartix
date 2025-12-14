@extends('layouts.main')

@section('page-title', 'Detail Produk')

@section('content')

<style>
    .container-detail {
        max-width: 1200px;
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

    .product-header {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(30, 58, 138, 0.1);
        margin-bottom: 25px;
    }

    .product-main {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 30px;
        align-items: start;
    }

    .product-image-wrapper {
        position: relative;
    }

    .product-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid rgba(30, 58, 138, 0.1);
        background: rgba(30, 58, 138, 0.02);
    }

    .no-image {
        width: 100%;
        height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(30, 58, 138, 0.05);
        border-radius: 12px;
        border: 2px dashed rgba(30, 58, 138, 0.2);
    }

    .no-image i {
        font-size: 80px;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .no-image p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .product-info h1 {
        margin: 0 0 15px 0;
        font-size: 32px;
        font-weight: 700;
        color: #1e3a8a;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .info-item {
        background: rgba(30, 58, 138, 0.03);
        padding: 15px;
        border-radius: 10px;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .info-item label {
        display: block;
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .info-item .value {
        font-size: 20px;
        font-weight: 700;
        color: #1e3a8a;
    }

    .info-item .value.price {
        color: #059669;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 5px;
    }

    .stock-badge.high {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .stock-badge.medium {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .stock-badge.low {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid rgba(30, 58, 138, 0.1);
    }

    .btn {
        padding: 10px 20px;
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

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
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

    .stat-icon.red {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .stat-card h4 {
        margin: 0;
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .value {
        font-size: 24px;
        font-weight: 700;
        color: #1e3a8a;
        margin: 5px 0 0 0;
    }

    .history-card {
        background: white;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .history-card h3 {
        margin: 0 0 20px 0;
        font-size: 20px;
        font-weight: 600;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .history-card h3 i {
        font-size: 24px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    }

    table th {
        padding: 14px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    table th:first-child {
        border-top-left-radius: 8px;
    }

    table th:last-child {
        border-top-right-radius: 8px;
    }

    table td {
        padding: 14px;
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
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
    }

    .status-selesai {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
    }

    .status-proses, .status-sedang {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
    }

    .status-belum {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
    }

    .status-menunggu {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
    }

    .status-dibatalkan {
        background: rgba(156, 163, 175, 0.15);
        color: #6b7280;
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
    }

    .empty-state h4 {
        font-size: 18px;
        margin: 15px 0 10px 0;
        color: #64748b;
    }

    .empty-state p {
        font-size: 14px;
        color: #94a3b8;
    }

    @media (max-width: 768px) {
        .product-main {
            grid-template-columns: 1fr;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        table {
            min-width: 800px;
        }
    }
</style>

<div class="container-detail">
    <a href="{{ route('product.index') }}" class="back-button">
        <i class='bx bx-arrow-back'></i> Kembali ke Daftar Produk
    </a>

    <!-- Product Header -->
    <div class="product-header">
        <div class="product-main">
            <div class="product-image-wrapper">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="product-image">
                @else
                    <div class="no-image">
                        <i class='bx bx-package'></i>
                        <p>Tidak ada gambar</p>
                    </div>
                @endif
            </div>

            <div class="product-info">
                <h1>{{ $product->product_name }}</h1>

                <div class="info-grid">
                    <div class="info-item">
                        <label>Harga per Unit</label>
                        <div class="value price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>

                    <div class="info-item">
                        <label>Stok Tersedia</label>
                        <div class="value">{{ number_format($product->stock) }} pcs</div>
                        @if($product->stock >= 500)
                            <span class="stock-badge high">
                                <i class='bx bx-check-circle'></i> Stok Aman
                            </span>
                        @elseif($product->stock >= 100)
                            <span class="stock-badge medium">
                                <i class='bx bx-info-circle'></i> Stok Sedang
                            </span>
                        @else
                            <span class="stock-badge low">
                                <i class='bx bx-error-circle'></i> Stok Rendah
                            </span>
                        @endif
                    </div>

                    <div class="info-item">
                        <label>Ditambahkan</label>
                        <div class="value" style="font-size: 14px;">{{ $product->created_at->format('d M Y') }}</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                            {{ $product->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Terakhir Update</label>
                        <div class="value" style="font-size: 14px;">{{ $product->updated_at->format('d M Y') }}</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                            {{ $product->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning">
                        <i class='bx bx-edit'></i> Edit Produk
                    </a>
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')" 
                          style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                @if($product->produksis->count() > 0) disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                            <i class='bx bx-trash'></i> Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">
                    <i class='bx bx-cog'></i>
                </div>
                <h4>Total Produksi</h4>
            </div>
            <p class="value">{{ $product->produksis->count() }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">
                    <i class='bx bx-check-circle'></i>
                </div>
                <h4>Produksi Selesai</h4>
            </div>
            <p class="value">{{ $product->produksis->where('status', 'Selesai')->count() }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon orange">
                    <i class='bx bx-time'></i>
                </div>
                <h4>Dalam Proses</h4>
            </div>
            <p class="value">{{ $product->produksis->whereIn('status', ['Proses', 'Sedang Diproses', 'Menunggu Bahan'])->count() }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon red">
                    <i class='bx bx-package'></i>
                </div>
                <h4>Total Unit Diproduksi</h4>
            </div>
            <p class="value">{{ number_format($product->produksis->where('status', 'Selesai')->sum('quantity')) }}</p>
        </div>
    </div>

    <!-- Production History -->
    <div class="history-card">
        <h3>
            <i class='bx bx-history'></i>
            Riwayat Produksi
        </h3>

        @if($product->produksis->count() > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Karyawan</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->produksis as $key => $produksi)
                    <tr>
                        <td><strong>{{ $key + 1 }}</strong></td>
                        <td>{{ $produksi->tanggal->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($produksi->waktu)->format('H:i') }}</td>
                        <td>
                            <strong>{{ $produksi->karyawan->nama_karyawan }}</strong><br>
                            <small style="color: #64748b;">{{ $produksi->karyawan->jabatan }}</small>
                        </td>
                        <td><strong>{{ number_format($produksi->quantity) }} pcs</strong></td>
                        <td>
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
                        </td>
                        <td>
                            {{ $produksi->keterangan ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class='bx bx-cog'></i>
            <h4>Belum ada riwayat produksi</h4>
            <p>Produk ini belum pernah diproduksi</p>
        </div>
        @endif
    </div>
</div>

@endsection