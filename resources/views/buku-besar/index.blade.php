@extends('layouts.main')

@section('page-title', 'Buku Besar')

@section('content')

<style>
    .dashboard-container {
        max-width: 100%;
        padding: 0;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header h2 {
        margin: 0 0 8px 0;
        font-size: 28px;
        font-weight: 700;
        color: white;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .page-header p {
        margin: 0;
        opacity: 0.8;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
    }

    .card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .card-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid rgba(37, 99, 235, 0.15);
    }

    .card-header-custom h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1e3a8a;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .alert-custom {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 500;
        animation: slideIn 0.4s ease;
        background: white;
    }

    .alert-info-custom {
        border-left: 4px solid #3b82f6;
        color: #1e3a8a;
        box-shadow: 0 2px 10px rgba(59, 130, 246, 0.15);
    }

    .alert-info-custom i {
        color: #3b82f6;
    }

    .alert-warning-custom {
        border-left: 4px solid #f59e0b;
        color: #92400e;
        box-shadow: 0 2px 10px rgba(245, 158, 11, 0.15);
    }

    .alert-warning-custom i {
        color: #f59e0b;
    }

    .alert-success-custom {
        border-left: 4px solid #10b981;
        color: #065f46;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.15);
    }

    .alert-success-custom i {
        color: #10b981;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #1e3a8a;
    }

    .form-control, .form-select {
        padding: 10px 15px;
        border-radius: 10px;
        border: 1px solid rgba(37, 99, 235, 0.2);
        background: rgba(37, 99, 235, 0.05);
        color: #1e3a8a;
        font-size: 14px;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #2563eb;
        background: rgba(37, 99, 235, 0.08);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-select option {
        background: white;
        color: #1e3a8a;
    }

    .table-container {
        overflow-x: auto;
        border-radius: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    table thead {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    }

    table th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: white;
        border: none;
    }

    table th.text-end {
        text-align: right;
    }

    table td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        color: #334155;
    }

    table td.text-end {
        text-align: right;
    }

    table tbody tr {
        transition: all 0.2s;
        background: white;
    }

    table tbody tr:hover {
        background: rgba(37, 99, 235, 0.05);
    }

    .saldo-awal-row {
        background: rgba(251, 191, 36, 0.15) !important;
        font-weight: 600;
    }

    .saldo-awal-row td {
        color: #92400e;
        border-bottom: 2px solid rgba(251, 191, 36, 0.3);
    }

    .bg-light-custom {
        background: rgba(37, 99, 235, 0.08) !important;
    }

    .bg-light-custom strong {
        color: #1e40af;
    }

    .total-row {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.15), rgba(30, 64, 175, 0.15)) !important;
        font-weight: 700;
        font-size: 14px;
    }

    .total-row td {
        color: #1e3a8a;
        border-bottom: 2px solid #2563eb;
        border-top: 2px solid #2563eb;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 25px;
    }

    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 28px 24px;
        text-align: center;
        border: 3px solid;
        transition: all 0.3s;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, transparent, currentColor, transparent);
        opacity: 0.5;
    }

    .summary-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18);
    }

    .summary-card.kas {
        border-color: #10b981;
        background: white;
        color: #10b981;
    }

    .summary-card.pendapatan {
        border-color: #2563eb;
        background: white;
        color: #2563eb;
    }

    .summary-card.beban {
        border-color: #ef4444;
        background: white;
        color: #ef4444;
    }

    .summary-card.modal {
        border-color: #8b5cf6;
        background: white;
        color: #8b5cf6;
    }

    .summary-card.hutang {
        border-color: #f59e0b;
        background: white;
        color: #f59e0b;
    }

    .summary-card.aset {
        border-color: #06b6d4;
        background: white;
        color: #06b6d4;
    }

    .summary-card h6 {
        margin: 0 0 15px 0;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 8px 12px;
        border-radius: 8px;
        background: white;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .summary-card.kas h6 {
        color: #10b981;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
    }

    .summary-card.pendapatan h6 {
        color: #2563eb;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
    }

    .summary-card.beban h6 {
        color: #ef4444;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
    }

    .summary-card.modal h6 {
        color: #8b5cf6;
        box-shadow: 0 2px 8px rgba(139, 92, 246, 0.2);
    }

    .summary-card.hutang h6 {
        color: #f59e0b;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
    }

    .summary-card.aset h6 {
        color: #06b6d4;
        box-shadow: 0 2px 8px rgba(6, 182, 212, 0.2);
    }

    .summary-card h4 {
        margin: 15px 0 0 0;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .summary-card.kas h4 {
        color: #10b981;
    }

    .summary-card.pendapatan h4 {
        color: #2563eb;
    }

    .summary-card.beban h4 {
        color: #ef4444;
    }

    .summary-card.modal h4 {
        color: #8b5cf6;
    }

    .summary-card.hutang h4 {
        color: #f59e0b;
    }

    .summary-card.aset h4 {
        color: #06b6d4;
    }

    @keyframes slideIn {
        from { 
            transform: translateY(-20px); 
            opacity: 0; 
        }
        to { 
            transform: translateY(0); 
            opacity: 1; 
        }
    }

    @media (max-width: 768px) {
        .filter-form {
            grid-template-columns: 1fr;
        }

        table {
            font-size: 12px;
        }

        table th, table td {
            padding: 10px 12px;
        }

        .card {
            padding: 20px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Header -->
    <div class="page-header">
        <h2>📚 Buku Besar</h2>
        <p>Catatan detail transaksi per akun</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-custom alert-success-custom">
            <i class='bx bx-check-circle' style="font-size: 20px;"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom alert-warning-custom">
            <i class='bx bx-error' style="font-size: 20px;"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card">
        <div class="card-header-custom">
            <h5>🔍 Filter Data</h5>
            <form action="{{ route('buku-besar.sync') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary" onclick="return confirm('Sinkronisasi akan mengambil semua data dari Jurnal Umum. Lanjutkan?')">
                    <i class='bx bx-refresh'></i> Sinkronisasi Data
                </button>
            </form>
        </div>

        <form method="GET" action="{{ route('buku-besar.index') }}" class="filter-form">
            <div class="form-group">
                <label>Akun</label>
                <select name="akun" class="form-select">
                    <option value="">Semua Akun</option>
                    @foreach($daftarAkun as $akun)
                        <option value="{{ $akun }}" {{ $akunFilter == $akun ? 'selected' : '' }}>
                            {{ $akun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
            </div>
            <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info">
                    <i class='bx bx-filter'></i> Filter
                </button>
                <a href="{{ route('buku-besar.export-pdf', request()->query()) }}" class="btn btn-danger" target="_blank">
                    <i class='bx bxs-file-pdf'></i> PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Info Periode -->
    <div class="alert-custom alert-info-custom">
        <i class='bx bx-info-circle' style="font-size: 20px;"></i>
        <div>
            <strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            @if($akunFilter)
                | <strong>Akun:</strong> {{ $akunFilter }}
            @else
                | <strong>Menampilkan:</strong> Semua Akun
            @endif
        </div>
    </div>

    @if($bukuBesarGrouped->isEmpty())
        <div class="alert-custom alert-warning-custom">
            <i class='bx bx-error' style="font-size: 20px;"></i>
            <div>Tidak ada data buku besar. Silakan klik <strong>Sinkronisasi Data</strong> terlebih dahulu.</div>
        </div>
    @else
        <!-- Loop per Akun -->
        @foreach($bukuBesarGrouped as $namaAkun => $items)
            <div class="card">
                <div class="card-header-custom">
                    <h5>
                        @if(stripos($namaAkun, 'Kas') !== false || stripos($namaAkun, 'Bank') !== false)
                            💰 Buku Besar - {{ $namaAkun }}
                        @elseif(stripos($namaAkun, 'Pendapatan') !== false)
                            💵 Buku Besar - {{ $namaAkun }}
                        @elseif(stripos($namaAkun, 'Beban') !== false)
                            💸 Buku Besar - {{ $namaAkun }}
                        @elseif(stripos($namaAkun, 'Modal') !== false)
                            💎 Buku Besar - {{ $namaAkun }}
                        @elseif(stripos($namaAkun, 'Hutang') !== false || stripos($namaAkun, 'Utang') !== false)
                            📋 Buku Besar - {{ $namaAkun }}
                        @elseif(stripos($namaAkun, 'Piutang') !== false)
                            📄 Buku Besar - {{ $namaAkun }}
                        @else
                            📊 Buku Besar - {{ $namaAkun }}
                        @endif
                    </h5>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="30%">Keterangan</th>
                                <th width="10%">No. Ref</th>
                                <th width="15%" class="text-end">Debit</th>
                                <th width="15%" class="text-end">Kredit</th>
                                <th width="20%" class="text-end">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Saldo Awal -->
                            @if(isset($saldoAwal[$namaAkun]) && $saldoAwal[$namaAkun] != 0)
                                <tr class="saldo-awal-row">
                                    <td colspan="3"><strong>Saldo Awal</strong></td>
                                    <td class="text-end">-</td>
                                    <td class="text-end">-</td>
                                    <td class="text-end"><strong>Rp {{ number_format($saldoAwal[$namaAkun], 0, ',', '.') }}</strong></td>
                                </tr>
                            @endif

                            <!-- Data Transaksi -->
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->no_referensi ?? '-' }}</td>
                                    <td class="text-end">
                                        @if($item->debit > 0)
                                            <span style="color: #10b981; font-weight: 600;">Rp {{ number_format($item->debit, 0, ',', '.') }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($item->kredit > 0)
                                            <span style="color: #ef4444; font-weight: 600;">Rp {{ number_format($item->kredit, 0, ',', '.') }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end bg-light-custom">
                                        <strong>Rp {{ number_format($item->saldo, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Total -->
                            <tr class="total-row">
                                <td colspan="3" class="text-end">TOTAL</td>
                                <td class="text-end">Rp {{ number_format($items->sum('debit'), 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($items->sum('kredit'), 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($items->last()->saldo, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        <!-- Summary Cards - Dinamis -->
        <div class="summary-grid">
            @foreach($bukuBesarGrouped as $namaAkun => $items)
                @php
                    $saldoAkhir = $items->last()->saldo ?? 0;
                    $cardClass = 'aset'; // default
                    $icon = '📊';
                    
                    // Tentukan class dan icon berdasarkan nama akun
                    if (stripos($namaAkun, 'Kas') !== false || stripos($namaAkun, 'Bank') !== false) {
                        $cardClass = 'kas';
                        $icon = '💰';
                    } elseif (stripos($namaAkun, 'Pendapatan') !== false) {
                        $cardClass = 'pendapatan';
                        $icon = '💵';
                    } elseif (stripos($namaAkun, 'Beban') !== false) {
                        $cardClass = 'beban';
                        $icon = '💸';
                    } elseif (stripos($namaAkun, 'Modal') !== false) {
                        $cardClass = 'modal';
                        $icon = '💎';
                    } elseif (stripos($namaAkun, 'Hutang') !== false || stripos($namaAkun, 'Utang') !== false) {
                        $cardClass = 'hutang';
                        $icon = '📋';
                    }
                @endphp
                
                <div class="summary-card {{ $cardClass }}">
                    <h6>{{ $icon }} {{ $namaAkun }}</h6>
                    <h4>Rp {{ number_format(abs($saldoAkhir), 0, ',', '.') }}</h4>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection