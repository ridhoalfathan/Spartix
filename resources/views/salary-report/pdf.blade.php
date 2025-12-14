@extends('layouts.main')

@section('page-title', 'Detail Salary Report')

@section('content')

<style>
    .detail-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(15px);
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        max-width: 900px;
        margin: 0 auto;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(255,255,255,0.2);
        flex-wrap: wrap;
        gap: 15px;
    }

    .detail-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .detail-header-left i {
        font-size: 32px;
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .detail-header-left h2 {
        margin: 0;
        font-size: 24px;
    }

    .status-badge {
        padding: 10px 24px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .status-badge.pending {
        background: rgba(251, 191, 36, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.3);
    }

    .status-badge.paid {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-badge.cancelled {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .info-section {
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .info-section h3 {
        margin: 0 0 20px 0;
        font-size: 18px;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-section h3 i {
        font-size: 22px;
        color: #06b6d4;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .info-item label {
        font-size: 12px;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .info-item .value {
        font-size: 15px;
        color: rgba(255,255,255,0.95);
        font-weight: 500;
    }

    .info-item .value.large {
        font-size: 24px;
        font-weight: 700;
        color: #10b981;
    }

    .info-item.full-width {
        grid-column: 1 / -1;
    }

    .calculation-box {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .calculation-box h3 {
        margin: 0 0 20px 0;
        font-size: 18px;
        font-weight: 600;
        color: #34d399;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .calc-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        font-size: 15px;
        color: rgba(255,255,255,0.9);
    }

    .calc-row.total {
        border-top: 2px solid rgba(16, 185, 129, 0.3);
        margin-top: 12px;
        padding-top: 20px;
        font-size: 20px;
        font-weight: 700;
        color: #34d399;
    }

    .jurnal-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .jurnal-info h4 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #60a5fa;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .jurnal-info p {
        margin: 8px 0;
        font-size: 14px;
        color: rgba(255,255,255,0.8);
    }

    .jurnal-info strong {
        color: #60a5fa;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 2px solid rgba(255,255,255,0.1);
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

    .btn-secondary {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.2);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
    }

    .btn-warning {
        background: linear-gradient(135deg, #ec4899, #db2777);
        color: white;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(236, 72, 153, 0.6);
    }

    .btn-danger {
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: white;
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.6);
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .detail-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .detail-card {
            padding: 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="detail-card">
    <div class="detail-header">
        <div class="detail-header-left">
            <i class='bx bx-file-blank'></i>
            <h2>Detail Salary Report</h2>
        </div>
        <span class="status-badge {{ $salaryReport->status ?? 'pending' }}">
            {{ $salaryReport->status_label }}
        </span>
    </div>

    <!-- Karyawan Info -->
    <div class="info-section">
        <h3><i class='bx bx-user'></i> Informasi Karyawan</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>ID Karyawan</label>
                <div class="value">{{ $salaryReport->karyawan->id_karyawan }}</div>
            </div>
            <div class="info-item">
                <label>Nama Karyawan</label>
                <div class="value">{{ $salaryReport->karyawan->nama_karyawan }}</div>
            </div>
            <div class="info-item">
                <label>Jabatan</label>
                <div class="value">{{ $salaryReport->karyawan->jabatan }}</div>
            </div>
            <div class="info-item">
                <label>Tanggal Report</label>
                <div class="value">{{ $salaryReport->tanggal->format('d F Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Salary Calculation -->
    <div class="calculation-box">
        <h3><i class='bx bx-calculator'></i> Perhitungan Gaji</h3>
        <div class="calc-row">
            <span>Gaji per Jam:</span>
            <strong>Rp {{ number_format($salaryReport->gaji_per_jam, 0, ',', '.') }}</strong>
        </div>
        <div class="calc-row">
            <span>Lama Bekerja:</span>
            <strong>{{ $salaryReport->lama_bekerja }} jam</strong>
        </div>
        <div class="calc-row">
            <span>Subtotal (Gaji × Jam):</span>
            <strong>Rp {{ number_format($salaryReport->gaji_per_jam * $salaryReport->lama_bekerja, 0, ',', '.') }}</strong>
        </div>
        <div class="calc-row">
            <span>Bonus:</span>
            <strong>Rp {{ number_format($salaryReport->bonus, 0, ',', '.') }}</strong>
        </div>
        <div class="calc-row total">
            <span>TOTAL GAJI:</span>
            <strong>Rp {{ number_format($salaryReport->total, 0, ',', '.') }}</strong>
        </div>
    </div>

    <!-- Payment Info -->
    @if($salaryReport->status === 'paid' && $salaryReport->tanggal_pembayaran)
    <div class="info-section">
        <h3><i class='bx bx-money'></i> Informasi Pembayaran</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Tanggal Pembayaran</label>
                <div class="value">{{ $salaryReport->tanggal_pembayaran->format('d F Y') }}</div>
            </div>
            <div class="info-item">
                <label>Metode</label>
                <div class="value">Transfer Bank / Kas</div>
            </div>
        </div>
    </div>
    @endif

    <!-- Jurnal Info -->
    @if($salaryReport->isDijurnal())
    <div class="jurnal-info">
        <h4><i class='bx bx-book'></i> Status Jurnal</h4>
        <p>✓ Jurnal akuntansi telah dibuat otomatis</p>
        <p><strong>No. Referensi:</strong> GAJI-{{ str_pad($salaryReport->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Debit:</strong> Beban Gaji - Rp {{ number_format($salaryReport->total, 0, ',', '.') }}</p>
        <p><strong>Kredit:</strong> Kas - Rp {{ number_format($salaryReport->total, 0, ',', '.') }}</p>
    </div>
    @endif

    <!-- Keterangan -->
    @if($salaryReport->keterangan)
    <div class="info-section">
        <h3><i class='bx bx-note'></i> Keterangan</h3>
        <div class="info-item full-width">
            <div class="value">{{ $salaryReport->keterangan }}</div>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('salary-report.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>

        @if($salaryReport->canBePaid())
            <form action="{{ route('salary-report.mark-paid', $salaryReport->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success" onclick="return confirm('Tandai sebagai sudah dibayar?')">
                    <i class='bx bx-check-circle'></i> Tandai Dibayar
                </button>
            </form>
        @endif

        @if($salaryReport->status !== 'paid')
            <a href="{{ route('salary-report.edit', $salaryReport->id) }}" class="btn btn-warning">
                <i class='bx bx-edit'></i> Edit
            </a>
        @endif

        <form action="{{ route('salary-report.destroy', $salaryReport->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class='bx bx-trash'></i> Hapus
            </button>
        </form>
    </div>
</div>

@endsection