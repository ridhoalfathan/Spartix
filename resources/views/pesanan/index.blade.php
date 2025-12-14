@extends('layouts.main')

@section('page-title', 'Data Pesanan')

@section('content')
<style>
    .container-pesanan {
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
    }

    .page-header h2 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-add {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        padding: 12px 28px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
    }

    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(30, 58, 138, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 25px;
    }

    .section-title {
        font-size: 22px;
        font-weight: 600;
        margin: 0 0 20px 0;
        color: #1e3a8a;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    }

    th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    th:first-child {
        border-top-left-radius: 10px;
    }

    th:last-child {
        border-top-right-radius: 10px;
    }

    td {
        padding: 16px;
        border-bottom: 1px solid rgba(30, 58, 138, 0.08);
        font-size: 14px;
        color: #334155;
    }

    tbody tr {
        transition: all 0.2s;
        background: white;
    }

    tbody tr:hover {
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

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        font-size: 16px;
        text-decoration: none;
    }

    .btn-view {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: white;
    }

    .btn-edit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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
        .container-pesanan {
            padding: 20px;
        }

        .page-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            min-width: 900px;
        }
    }
</style>

<div class="container-pesanan">
    <div class="page-header">
        <h2>Data Pesanan</h2>
        <a href="{{ route('pesanan.create') }}" class="btn-add">
            <i class='bx bx-plus'></i> Tambah Pesanan
        </a>
    </div>

    <div class="table-container">
        <div class="section-title">Daftar Pesanan</div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pesanan</th>
                        <th>Nama Pemesan</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Pesanan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $index => $pesanan)
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td><strong>{{ $pesanan->id_pesanan }}</strong></td>
                        <td>{{ $pesanan->nama_pemesan }}</td>
                        <td><strong>{{ $pesanan->product->product_name ?? '-' }}</strong></td>
                        <td><strong>{{ number_format($pesanan->jumlah_pesanan) }} Pcs</strong></td>
                        <td>{{ $pesanan->tanggal_pembayaran->format('d M Y') }}</td>
                        <td>
                            <span class="status-badge {{ $pesanan->status == 'Complete' ? 'status-complete' : 'status-pending' }}">
                                {{ $pesanan->status }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('pesanan.show', $pesanan->id) }}" class="btn-action btn-view" title="Lihat Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                                <a href="{{ route('pesanan.edit', $pesanan->id) }}" class="btn-action btn-edit" title="Edit">
                                    <i class='bx bx-edit'></i>
                                </a>
                                <form action="{{ route('pesanan.destroy', $pesanan->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class='bx bx-receipt'></i>
                                <h3>Belum ada data pesanan</h3>
                                <p>Klik tombol "Tambah Pesanan" untuk menambahkan data baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection