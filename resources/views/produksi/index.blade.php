@extends('layouts.main')

@section('page-title', 'Data Produksi')

@section('content')

<style>
    .container-produksi {
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
        font-size: 22px;
        margin: 0 0 20px 0;
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

    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .status-selesai {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-belum {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .status-sedang {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .status-dibatalkan {
        background: rgba(156, 163, 175, 0.15);
        color: #6b7280;
        border: 1px solid rgba(156, 163, 175, 0.3);
    }

    .status-proses {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .status-menunggu {
        background: rgba(249, 115, 22, 0.15);
        color: #ea580c;
        border: 1px solid rgba(249, 115, 22, 0.3);
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

    .product-name {
        font-weight: 600;
        color: #1e3a8a;
    }

    .karyawan-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .karyawan-name {
        font-weight: 600;
        color: #334155;
    }

    .karyawan-jabatan {
        font-size: 12px;
        color: #64748b;
        font-style: italic;
    }

    .quantity-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: rgba(30, 58, 138, 0.08);
        border-radius: 8px;
        font-weight: 600;
        color: #1e3a8a;
    }

    .quantity-badge i {
        font-size: 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-produksi {
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
            min-width: 1100px;
        }
    }
</style>

<div class="container-produksi">
    <div class="page-header">
        <h2>Data Produksi</h2>
        <a href="{{ route('produksi.create') }}" class="btn btn-primary">
            <i class='bx bx-plus'></i> Tambah Produksi
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">
                    <i class='bx bx-cog'></i>
                </div>
                <h4>Total Produksi</h4>
            </div>
            <p class="value">{{ number_format($produksis->count()) }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">
                    <i class='bx bx-check-circle'></i>
                </div>
                <h4>Selesai</h4>
            </div>
            <p class="value">{{ number_format($produksis->where('status', 'Selesai')->count()) }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon orange">
                    <i class='bx bx-time'></i>
                </div>
                <h4>Dalam Proses</h4>
            </div>
            <p class="value">{{ number_format($produksis->whereIn('status', ['Sedang Diproses', 'Proses', 'Menunggu Bahan'])->count()) }}</p>
        </div>
    </div>

    <div class="table-card">
        <h3>Daftar Produksi</h3>
        
        @if($produksis->count() > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Karyawan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produksis as $key => $produksi)
                    <tr>
                        <td><strong>{{ $key + 1 }}</strong></td>
                        <td>
                            <span class="product-name">{{ $produksi->product->product_name }}</span>
                        </td>
                        <td>
                            <div class="karyawan-info">
                                <span class="karyawan-name">{{ $produksi->karyawan->nama_karyawan }}</span>
                                <span class="karyawan-jabatan">{{ $produksi->karyawan->jabatan }}</span>
                            </div>
                        </td>
                        <td>{{ $produksi->tanggal->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($produksi->waktu)->format('H:i') }}</td>
                        <td>
                            <span class="quantity-badge">
                                <i class='bx bx-package'></i>
                                {{ number_format($produksi->quantity) }}
                            </span>
                        </td>
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
                            <div class="actions">
                                <a href="{{ route('produksi.show', $produksi->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                                <a href="{{ route('produksi.edit', $produksi->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class='bx bx-edit'></i>
                                </a>
                                <form action="{{ route('produksi.destroy', $produksi->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus data produksi ini?\n\n{{ $produksi->status === 'Selesai' ? 'Perhatian: Stok produk akan dikurangi!' : '' }}')" 
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
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
            <i class='bx bx-cog'></i>
            <h3>Belum ada data produksi</h3>
            <p>Klik tombol "Tambah Produksi" untuk menambahkan data baru</p>
        </div>
        @endif
    </div>
</div>

@endsection