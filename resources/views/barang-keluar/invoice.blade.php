@extends('layouts.main')

@section('title', 'Invoice Penjualan - ' . $nomorTransaksi)

@section('styles')
<style>
    .invoice-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        margin-bottom: 2rem;
    }
    .invoice-header {
        display: flex;
        justify-content: space-between;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
    }
    .invoice-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1e3a8a;
        margin: 0;
    }
    .invoice-meta {
        text-align: right;
    }
    .invoice-meta p {
        margin: 0;
        color: #475569;
        font-size: 0.95rem;
    }
    .customer-info {
        margin-bottom: 2rem;
    }
    .customer-info h5 {
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.5rem;
    }
    .table-invoice {
        width: 100%;
        margin-bottom: 2rem;
    }
    .table-invoice th {
        background: #f8fafc;
        padding: 1rem;
        font-weight: 700;
        color: #334155;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-invoice td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    .table-invoice .qty {
        text-align: center;
    }
    .table-invoice .amount {
        text-align: right;
    }
    .invoice-total {
        width: 300px;
        margin-left: auto;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 1.1rem;
    }
    .total-row.grand-total {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e3a8a;
        border-top: 2px solid #e2e8f0;
        padding-top: 1rem;
        margin-top: 0.5rem;
    }
    
    @media print {
        body {
            background: white;
            padding: 0;
            margin: 0;
        }
        .navbar, .sidebar, .btn-print, .btn-back, .page-header {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .invoice-card {
            box-shadow: none;
            padding: 0;
            margin: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary btn-back">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
    </a>
    <button onclick="window.print()" class="btn btn-primary btn-print">
        <i class="bi bi-printer"></i> Cetak Invoice
    </button>
</div>

<div class="invoice-card">
    <div class="invoice-header">
        <div>
            <h1 class="invoice-title">INVOICE</h1>
            <p class="mt-2 mb-0" style="color: #64748b;"><strong>RAYA-E</strong> Electronic Store</p>
        </div>
        <div class="invoice-meta">
            <h4 style="font-weight: 700; color: #334155;">#{{ $nomorTransaksi }}</h4>
            <p>Tanggal: <strong>{{ \Carbon\Carbon::parse($barangKeluar->first()->tanggal_keluar)->format('d F Y') }}</strong></p>
            <p>Pembayaran: <strong style="text-transform: uppercase; color: #2563eb;">{{ $barangKeluar->first()->metode_pembayaran }}</strong></p>
        </div>
    </div>
    
    <div class="customer-info">
        <h5>Kepada:</h5>
        <p style="font-size: 1.1rem; color: #475569; margin: 0;">
            {{ $barangKeluar->first()->customer ?: 'Pelanggan Umum' }}
        </p>
        @if($barangKeluar->first()->keterangan)
        <p style="color: #64748b; margin-top: 0.5rem; font-style: italic;">
            Catatan: {{ $barangKeluar->first()->keterangan }}
        </p>
        @endif
    </div>
    
    <table class="table-invoice">
        <thead>
            <tr>
                <th>Item / Barang</th>
                <th class="qty">Qty</th>
                <th class="amount">Harga (Rp)</th>
                <th class="amount">Subtotal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $grandTotal = 0;
                // Group by barang_id and harga_jual to show as grouped items instead of individual serial numbers if they have the same price
                // But wait, it's better to group them by barang_id and harga_jual, and list the serial numbers
                $grouped = [];
                foreach($barangKeluar as $item) {
                    $key = $item->barang_id . '-' . $item->harga_jual;
                    if(!isset($grouped[$key])) {
                        $grouped[$key] = [
                            'nama' => $item->barang->nama_barang,
                            'harga_jual' => $item->harga_jual,
                            'qty' => 0,
                            'serial_numbers' => []
                        ];
                    }
                    $grouped[$key]['qty'] += 1;
                    $grouped[$key]['serial_numbers'][] = $item->serialNumber->serial_number;
                }
            @endphp
            
            @foreach($grouped as $group)
            @php 
                $subtotal = $group['qty'] * $group['harga_jual'];
                $grandTotal += $subtotal;
            @endphp
            <tr>
                <td>
                    <strong style="color: #1e293b;">{{ $group['nama'] }}</strong>
                    <div style="font-size: 0.85rem; color: #64748b; margin-top: 4px; font-family: monospace;">
                        SN: {{ implode(', ', $group['serial_numbers']) }}
                    </div>
                </td>
                <td class="qty">{{ $group['qty'] }}</td>
                <td class="amount">{{ number_format($group['harga_jual'], 0, ',', '.') }}</td>
                <td class="amount">{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="invoice-total">
        <div class="total-row grand-total">
            <span>Total Tagihan</span>
            <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
        </div>
    </div>
    
    <div style="margin-top: 4rem; text-align: center; color: #64748b;">
        <p>Terima kasih atas kepercayaan Anda berbelanja di RAYA-E.</p>
    </div>
</div>
@endsection
