@extends('layouts.main')

@section('page-title', 'Data Produk')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-header h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 600;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    .btn-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
    }

    .table-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(15px);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .table-card h3 {
        margin: 0 0 20px 0;
        font-size: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: white;
        margin-top: 20px;
    }

    table thead {
        background: rgba(255,255,255,0.1);
    }

    table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid rgba(255,255,255,0.2);
    }

    table td {
        padding: 12px 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    table tbody tr {
        transition: 0.2s;
    }

    table tbody tr:hover {
        background: rgba(255,255,255,0.1);
    }

    .product-image-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        background: rgba(255,255,255,0.1);
        padding: 5px;
    }

    .no-image-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        font-size: 30px;
        color: rgba(255,255,255,0.3);
    }

    .stock-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
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

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        opacity: 0.7;
    }

    .empty-state i {
        font-size: 80px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        table {
            font-size: 13px;
        }

        table th, table td {
            padding: 10px;
        }

        .actions {
            flex-direction: column;
        }

        .btn-sm {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-header">
    <h2>Data Produk</h2>
    <a href="{{ route('product.create') }}" class="btn btn-primary">
        <i class='bx bx-plus'></i> Tambah Produk
    </a>
</div>

<div class="table-card">
    <h3>Daftar Produk</h3>
    
    @if($products->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $key => $product)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->product_name }}" class="product-image-thumbnail">
                    @else
                        <div class="no-image-icon">
                            <i class='bx bx-package'></i>
                        </div>
                    @endif
                </td>
                <td><strong>{{ $product->product_name }}</strong></td>
                <td>{{ number_format($product->stock) }}</td>
                <td>
                    @if($product->stock >= 500)
                        <span class="stock-badge stock-high">Stock Aman</span>
                    @elseif($product->stock >= 100)
                        <span class="stock-badge stock-medium">Stock Sedang</span>
                    @else
                        <span class="stock-badge stock-low">Stock Rendah</span>
                    @endif
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-info btn-sm">
                            <i class='bx bx-show'></i> Detail
                        </a>
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <i class='bx bx-edit'></i> Edit
                        </a>
                        <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class='bx bx-trash'></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <i class='bx bx-package'></i>
        <h3>Belum ada produk</h3>
        <p>Klik tombol "Tambah Produk" untuk menambahkan produk baru</p>
    </div>
    @endif
</div>

@endsection