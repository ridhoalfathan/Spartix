@extends('layouts.main')

@section('page-title', 'Detail Buku Besar')

@section('content')

<style>
    .detail-container {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-left i {
        font-size: 42px;
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .header-title h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: white;
    }

    .header-subtitle {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
    }

    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
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
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
    }

    .btn-warning {
        background: linear-gradient(135deg, #ec4899, #db2777);
        color: white;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(236, 72, 153, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-secondary {
        background: rgba(156, 163, 175, 0.3);
        color: white;
        border: 1px solid rgba(156, 163, 175, 0.5);
    }

    .btn-secondary:hover {
        background: rgba(156, 163, 175, 0.5);
    }

    /* Account Info Section */
    .account-info {
        background: rgba(6, 182, 212, 0.1);
        border: 1px solid rgba(6, 182, 212, 0.3);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .account-info h3 {
        margin: 0 0 20px 0;
        color: #22d3ee;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .info-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .info-value {
        font-size: 16px;
        color: white;
        font-weight: 500;
    }

    .badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .badge-aset { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
    .badge-liabilitas { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-ekuitas { background: rgba(139, 92, 246, 0.15); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.3); }
    .badge-pendapatan { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge-beban { background: rgba(249, 115, 22, 0.15); color: #fb923c; border: 1px solid rgba(249, 115, 22, 0.3); }
    .badge-debit { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge-kredit { background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-active { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge-inactive { background: rgba(107, 114, 128, 0.15); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3); }

    /* Filter Section */
    .filter-section {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 25px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .filter-form {
        display: flex;
        gap: 15px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    .filter-group label {
        font-size: 13px;
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-group input {
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.08);
        color: white;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s;
    }

    .filter-group input:focus {
        outline: none;
        border-color: rgba(6, 182, 212, 0.5);
        background: rgba(255, 255, 255, 0.12);
    }

    /* Ledger Table */
    .ledger-container {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 16px;
        overflow: hidden;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        padding: 25px;
    }

    .ledger-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .ledger-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: white;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: rgba(255, 255, 255, 0.05);
    }

    th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    th.text-right {
        text-align: right;
    }

    td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
    }

    td.text-right {
        text-align: right;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
    }

    tbody tr {
        transition: all 0.2s;
    }

    tbody tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .debit-value {
        color: #10b981;
        font-weight: 600;
    }

    .kredit-value {
        color: #ef4444;
        font-weight: 600;
    }

    .saldo-value {
        color: #22d3ee;
        font-weight: 700;
        font-size: 15px;
    }

    .total-row {
        background: rgba(6, 182, 212, 0.1) !important;
        border-top: 2px solid rgba(6, 182, 212, 0.3) !important;
        font-weight: 600;
    }

    .total-row td {
        padding: 18px 16px;
        color: #22d3ee;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255, 255, 255, 0.5);
    }

    .empty-state i {
        font-size: 64px;
        opacity: 0.3;
        margin-bottom: 15px;
        display: block;
    }

    .empty-state h3 {
        font-size: 20px;
        margin: 15px 0 10px 0;
        color: rgba(255, 255, 255, 0.7);
    }

    .empty-state p {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.5);
    }

    @media (max-width: 768px) {
        .detail-container {
            padding: 20px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            width: 100%;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .ledger-container {
            overflow-x: auto;
        }

        table {
            min-width: 900px;
        }
    }
</style>

<div class="detail-container">
    <div class="page-header">
        <div class="header-left">
            <i class='bx bx-book-open'></i>
            <div class="header-title">
                <h2>{{ $bukuBesar->nama_akun }}</h2>
                <div class="header-subtitle">Kode Akun: {{ $bukuBesar->kode_akun }}</div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('buku-besar.export-pdf', ['bukuBesar' => $bukuBesar->id, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success">
                <i class='bx bxs-file-pdf'></i> Export PDF
            </a>
            <a href="{{ route('buku-besar.edit', $bukuBesar->id) }}" class="btn btn-warning">
                <i class='bx bx-edit'></i> Edit
            </a>
            <a href="{{ route('buku-besar.index') }}" class="btn btn-secondary">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>
    </div>

    <!-- Account Info -->
    <div class="account-info">
        <h3><i class='bx bx-info-circle'></i> Informasi Akun</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Kode Akun</span>
                <span class="info-value">{{ $bukuBesar->kode_akun }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Akun</span>
                <span class="info-value">{{ $bukuBesar->nama_akun }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jenis Akun</span>
                <span class="info-value">
                    <span class="badge badge-{{ strtolower($bukuBesar->jenis_akun) }}">
                        {{ $bukuBesar->jenis_akun }}
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Posisi Normal</span>
                <span class="info-value">
                    <span class="badge badge-{{ strtolower($bukuBesar->posisi_normal) }}">
                        {{ $bukuBesar->posisi_normal }}
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Saldo Awal</span>
                <span class="info-value">Rp {{ number_format($bukuBesar->saldo_awal, 0, ',', '.') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="info-value">
                    @if($bukuBesar->is_active)
                        <span class="badge badge-active">Aktif</span>
                    @else
                        <span class="badge badge-inactive">Nonaktif</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form action="{{ route('buku-besar.show', $bukuBesar->id) }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label>Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="filter-group">
                <label>Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-search'></i> Filter
            </button>
            @if($startDate || $endDate)
                <a href="{{ route('buku-besar.show', $bukuBesar->id) }}" class="btn btn-secondary">
                    <i class='bx bx-reset'></i> Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Ledger Table -->
    <div class="ledger-container">
        <div class="ledger-header">
            <h3>📖 Transaksi Buku Besar</h3>
        </div>

        @if(count($entries) > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 110px;">Tanggal</th>
                    <th>Keterangan</th>
                    <th style="width: 100px;">Ref</th>
                    <th class="text-right" style="width: 140px;">Debit</th>
                    <th class="text-right" style="width: 140px;">Kredit</th>
                    <th class="text-right" style="width: 150px;">Saldo</th>
                </tr>
            </thead>
            <tbody>
                <!-- Saldo Awal -->
                <tr style="background: rgba(59, 130, 246, 0.05);">
                    <td>-</td>
                    <td><strong>Saldo Awal</strong></td>
                    <td>-</td>
                    <td class="text-right">-</td>
                    <td class="text-right">-</td>
                    <td class="text-right saldo-value">Rp {{ number_format($bukuBesar->saldo_awal, 0, ',', '.') }}</td>
                </tr>

                @php
                    $totalDebit = 0;
                    $totalKredit = 0;
                @endphp

                @foreach($entries as $entry)
                @php
                    $totalDebit += $entry['debit'];
                    $totalKredit += $entry['kredit'];
                @endphp
                <tr>
                    <td>{{ $entry['tanggal']->format('d M Y') }}</td>
                    <td>{{ $entry['keterangan'] }}</td>
                    <td>{{ $entry['ref'] }}</td>
                    <td class="text-right">
                        @if($entry['debit'] > 0)
                            <span class="debit-value">Rp {{ number_format($entry['debit'], 0, ',', '.') }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        @if($entry['kredit'] > 0)
                            <span class="kredit-value">Rp {{ number_format($entry['kredit'], 0, ',', '.') }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right saldo-value">Rp {{ number_format($entry['saldo'], 0, ',', '.') }}</td>
                </tr>
                @endforeach

                <!-- Total Row -->
                <tr class="total-row">
                    <td colspan="3" class="text-right"><strong>TOTAL:</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalDebit, 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalKredit, 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format(end($entries)['saldo'], 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class='bx bx-book'></i>
            <h3>Belum ada transaksi</h3>
            <p>Transaksi akan muncul di sini setelah dicatat di Jurnal Umum</p>
        </div>
        @endif
    </div>
</div>

@endsection