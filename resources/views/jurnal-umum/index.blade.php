@extends('layouts.main')

@section('page-title', 'Jurnal Umum')

@section('content')
<style>
    .container-jurnal {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(30, 58, 138, 0.1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
        color: #1e3a8a;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-sync {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-sync:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-export {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .filter-section {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        border: 1px solid rgba(37, 99, 235, 0.15);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filter-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1e3a8a;
    }

    .filter-title i {
        color: #2563eb;
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
        color: #1e3a8a;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-group input,
    .filter-group select {
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid rgba(37, 99, 235, 0.2);
        background: rgba(37, 99, 235, 0.05);
        color: #1e3a8a;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        border-color: #2563eb;
        background: rgba(37, 99, 235, 0.08);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-group select option {
        background: white;
        color: #1e3a8a;
    }

    .filter-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-filter {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-reset {
        background: white;
        color: #64748b;
        padding: 12px 24px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        transform: translateY(-2px);
    }

    .summary-box {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .summary-item {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 2px solid;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .summary-item.debit {
        border-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(5, 150, 105, 0.05));
    }

    .summary-item.kredit {
        border-color: #ef4444;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(220, 38, 38, 0.05));
    }

    .summary-item.saldo {
        border-color: #2563eb;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(30, 64, 175, 0.05));
    }

    .summary-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .summary-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 600;
    }

    .summary-value {
        font-size: 28px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
    }

    .summary-item.debit .summary-value {
        color: #10b981;
    }

    .summary-item.kredit .summary-value {
        color: #ef4444;
    }

    .summary-item.saldo .summary-value {
        color: #2563eb;
    }

    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(37, 99, 235, 0.15);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 25px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    }

    th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
    }

    th.text-right {
        text-align: right;
    }

    td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        font-size: 14px;
        color: #334155;
    }

    td.text-right {
        text-align: right;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
    }

    tr.jurnal-entry {
        border-left: 3px solid transparent;
        transition: all 0.2s;
        background: white;
    }

    tr.jurnal-entry:hover {
        background: rgba(37, 99, 235, 0.05);
        border-left-color: #2563eb;
    }

    tr.debit-row {
        background: rgba(16, 185, 129, 0.03);
    }

    tr.kredit-row {
        background: rgba(239, 68, 68, 0.03);
        border-bottom: 2px solid rgba(37, 99, 235, 0.15) !important;
    }

    tr.kredit-row td {
        border-bottom: none;
    }

    td.indent {
        padding-left: 40px;
    }

    .badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-auto {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .badge-manual {
        background: rgba(37, 99, 235, 0.15);
        color: #1e40af;
        border: 1px solid rgba(37, 99, 235, 0.3);
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 2px solid;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        font-size: 20px;
        text-decoration: none;
        position: relative;
        background: white;
    }

    .btn-view {
        border-color: #10b981;
        color: #10b981;
    }

    .btn-view:hover {
        background: #10b981;
        color: white;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .btn-edit {
        border-color: #f59e0b;
        color: #f59e0b;
    }

    .btn-edit:hover {
        background: #f59e0b;
        color: white;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }

    .btn-delete {
        border-color: #ef4444;
        color: #ef4444;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .btn-lock {
        border-color: #9ca3af;
        color: #9ca3af;
        cursor: not-allowed;
    }

    .btn-lock:hover {
        transform: none;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .empty-state i {
        font-size: 64px;
        opacity: 0.3;
        margin-bottom: 15px;
        display: block;
        color: #2563eb;
    }

    .empty-state h3 {
        font-size: 20px;
        margin: 15px 0 10px 0;
        color: #1e3a8a;
    }

    .empty-state p {
        font-size: 14px;
        color: #64748b;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #059669;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #dc2626;
    }

    @media (max-width: 768px) {
        .container-jurnal {
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

        .summary-box {
            grid-template-columns: 1fr;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            min-width: 1000px;
        }
    }
</style>

<div class="container-jurnal">
    <div class="page-header">
        <h2>📒 Jurnal Umum</h2>
        <div class="header-actions">
            <form action="{{ route('jurnal-umum.sync') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-sync" onclick="return confirm('Sinkronisasi data dari Pembelian, Transaksi, dan Gaji?')">
                    <i class='bx bx-sync'></i> Sinkronisasi Data
                </button>
            </form>
            <a href="{{ route('jurnal-umum.export-pdf', ['start_date' => $startDate, 'end_date' => $endDate, 'sumber' => $sumber]) }}" class="btn-export">
                <i class='bx bxs-file-pdf'></i> Export PDF
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class='bx bx-check-circle'></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class='bx bx-error-circle'></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">
            <i class='bx bx-filter-alt'></i> Filter Data
        </div>
        <form action="{{ route('jurnal-umum.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label>Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="filter-group">
                <label>Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}">
            </div>
            <div class="filter-group">
                <label>Sumber Data</label>
                <select name="sumber">
                    <option value="semua" {{ $sumber == 'semua' ? 'selected' : '' }}>Semua</option>
                    <option value="pembelian" {{ $sumber == 'pembelian' ? 'selected' : '' }}>Pembelian</option>
                    <option value="transaksi" {{ $sumber == 'transaksi' ? 'selected' : '' }}>Transaksi/Penjualan</option>
                    <option value="salary_report" {{ $sumber == 'salary_report' ? 'selected' : '' }}>Gaji Karyawan</option>
                    <option value="manual" {{ $sumber == 'manual' ? 'selected' : '' }}>Input Manual</option>
                </select>
            </div>
            <div class="filter-buttons">
                <button type="submit" class="btn-filter">
                    <i class='bx bx-search'></i> Filter
                </button>
                @if($startDate || $endDate || $sumber)
                <a href="{{ route('jurnal-umum.index') }}" class="btn-reset">
                    <i class='bx bx-reset'></i> Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Summary -->
    <div class="summary-box">
        <div class="summary-item debit">
            <div class="summary-label">Total Debit</div>
            <div class="summary-value">Rp {{ number_format($totalDebit, 0, ',', '.') }}</div>
        </div>
        <div class="summary-item kredit">
            <div class="summary-label">Total Kredit</div>
            <div class="summary-value">Rp {{ number_format($totalKredit, 0, ',', '.') }}</div>
        </div>
        <div class="summary-item saldo">
            <div class="summary-label">Selisih</div>
            <div class="summary-value">Rp {{ number_format($totalDebit - $totalKredit, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 110px;">Tanggal</th>
                    <th style="width: 100px;">Sumber</th>
                    <th>Keterangan</th>
                    <th style="width: 180px;">Akun</th>
                    <th class="text-right" style="width: 150px;">Debit</th>
                    <th class="text-right" style="width: 150px;">Kredit</th>
                    <th style="width: 100px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jurnals as $index => $jurnal)
                <!-- Baris Debit -->
                <tr class="jurnal-entry debit-row">
                    <td rowspan="2"><strong>{{ $index + 1 }}</strong></td>
                    <td rowspan="2">{{ $jurnal->tanggal->format('d M Y') }}</td>
                    <td rowspan="2">
                        @if($jurnal->isManual())
                            <span class="badge badge-manual">Manual</span>
                        @else
                            <span class="badge badge-auto">
                                @if($jurnal->sumber_transaksi == 'pembelian')
                                    Pembelian
                                @elseif($jurnal->sumber_transaksi == 'transaksi')
                                    Penjualan
                                @elseif($jurnal->sumber_transaksi == 'salary_report')
                                    Gaji
                                @endif
                            </span>
                        @endif
                    </td>
                    <td rowspan="2">
                        {{ $jurnal->keterangan }}
                        @if($jurnal->no_referensi)
                            <br><small style="color: #64748b;">Ref: {{ $jurnal->no_referensi }}</small>
                        @endif
                    </td>
                    <td><strong>{{ $jurnal->akun_debit }}</strong></td>
                    <td class="text-right"><strong style="color: #10b981;">Rp {{ number_format($jurnal->debit, 0, ',', '.') }}</strong></td>
                    <td class="text-right">-</td>
                    <td rowspan="2">
                        <div class="action-buttons">
                            @if($jurnal->isManual())
                                <a href="{{ route('jurnal-umum.show', $jurnal->id) }}" class="btn-action btn-view" title="Lihat Detail">
                                    <i class='bx bxs-show'></i>
                                </a>
                                <a href="{{ route('jurnal-umum.edit', $jurnal->id) }}" class="btn-action btn-edit" title="Edit Jurnal">
                                    <i class='bx bxs-edit'></i>
                                </a>
                                <form action="{{ route('jurnal-umum.destroy', $jurnal->id) }}" method="POST" onsubmit="return confirm('⚠️ Yakin ingin menghapus jurnal ini?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus Jurnal">
                                        <i class='bx bxs-trash'></i>
                                    </button>
                                </form>
                            @else
                                <button class="btn-action btn-lock" disabled title="🔒 Data Otomatis - Tidak Dapat Diubah">
                                    <i class='bx bxs-lock-alt'></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                <!-- Baris Kredit -->
                <tr class="jurnal-entry kredit-row">
                    <td class="indent"><strong>{{ $jurnal->akun_kredit }}</strong></td>
                    <td class="text-right">-</td>
                    <td class="text-right"><strong style="color: #ef4444;">Rp {{ number_format($jurnal->kredit, 0, ',', '.') }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class='bx bx-file'></i>
                            <h3>Belum ada data jurnal</h3>
                            <p>Klik "Sinkronisasi Data" untuk mengambil data otomatis dari sistem</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection