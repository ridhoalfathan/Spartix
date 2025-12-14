@extends('layouts.main')

@section('page-title', 'Detail Pembelian')

@section('content')

<style>
    .detail-card {
        background: white;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 1000px;
        margin: 0 auto;
    }

    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
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
        color: #2563eb;
    }

    .detail-header h2 {
        margin: 0;
        font-size: 24px;
        color: #1e293b;
        font-weight: 600;
    }

    .detail-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    .info-group {
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #2563eb;
    }

    .info-group.full-width {
        grid-column: 1 / -1;
    }

    .info-group.highlight {
        background: #eff6ff;
        border-left-color: #3b82f6;
    }

    .info-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .info-value {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
    }

    .info-value.large {
        font-size: 28px;
        color: #10b981;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-complete {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .metadata {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #e5e7eb;
    }

    .metadata-item {
        background: #f8fafc;
        padding: 12px;
        border-radius: 8px;
        font-size: 13px;
        color: #475569;
    }

    .metadata-item strong {
        display: block;
        color: #1e293b;
        margin-bottom: 3px;
        font-weight: 600;
    }

    .detail-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        padding-top: 20px;
        border-top: 2px solid #e5e7eb;
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
        background: white;
        color: #64748b;
        border: 2px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    .btn-warning:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }

    .btn-danger {
        background: #ef4444;
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
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
            <i class='bx bx-file'></i>
            <h2>Detail Pembelian</h2>
        </div>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
    </div>

    <div class="detail-content">
        <div class="info-group">
            <div class="info-label">ID Pembelian</div>
            <div class="info-value">{{ $pembelian->id_pembelian }}</div>
        </div>

        <div class="info-group">
            <div class="info-label">Nama Supplier</div>
            <div class="info-value">{{ $pembelian->nama_supplier }}</div>
        </div>

        <div class="info-group full-width">
            <div class="info-label">Nama Barang</div>
            <div class="info-value">{{ $pembelian->nama_barang }}</div>
        </div>

        <div class="info-group highlight">
            <div class="info-label">Total Pembelian</div>
            <div class="info-value large">Rp {{ number_format($pembelian->total_pembelian, 0, ',', '.') }}</div>
        </div>

        <div class="info-group">
            <div class="info-label">Tanggal Pembelian</div>
            <div class="info-value">{{ $pembelian->tanggal_pembelian->format('d F Y') }}</div>
        </div>

        <div class="info-group full-width">
            <div class="info-label">Status</div>
            <div class="info-value">
                <span class="status-badge status-{{ strtolower($pembelian->status) }}">
                    @if($pembelian->status == 'Complete')
                        <i class='bx bx-check-circle'></i>
                    @elseif($pembelian->status == 'Pending')
                        <i class='bx bx-time'></i>
                    @else
                        <i class='bx bx-x-circle'></i>
                    @endif
                    {{ $pembelian->status }}
                </span>
            </div>
        </div>
    </div>

    <!-- Metadata -->
    <div class="metadata">
        <div class="metadata-item">
            <strong>Dibuat Pada:</strong>
            {{ $pembelian->created_at->format('d M Y, H:i') }}
        </div>
        <div class="metadata-item">
            <strong>Terakhir Update:</strong>
            {{ $pembelian->updated_at->format('d M Y, H:i') }}
        </div>
    </div>

    <div class="detail-actions">
        <a href="{{ route('pembelian.edit', $pembelian->id) }}" class="btn btn-warning">
            <i class='bx bx-edit'></i> Edit Pembelian
        </a>
        <form action="{{ route('pembelian.destroy', $pembelian->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pembelian ini?')" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class='bx bx-trash'></i> Hapus Pembelian
            </button>
        </form>
    </div>
</div>

@endsection