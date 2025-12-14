@extends('layouts.main')

@section('page-title', 'Detail Jurnal Umum')

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
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(255,255,255,0.2);
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-left i {
        font-size: 32px;
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .header-left h2 {
        margin: 0;
        font-size: 24px;
        color: white;
    }

    .detail-actions {
        display: flex;
        gap: 10px;
    }

    /* Info Section */
    .info-section {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .info-section h3 {
        margin: 0 0 20px 0;
        color: #60a5fa;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
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

    /* Keterangan Section */
    .keterangan-section {
        background: rgba(139, 92, 246, 0.1);
        border: 1px solid rgba(139, 92, 246, 0.3);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .keterangan-section h3 {
        margin: 0 0 15px 0;
        color: #a78bfa;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .keterangan-text {
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.6;
        font-size: 14px;
    }

    /* Transaction Section */
    .transaction-display {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .debit-display,
    .kredit-display {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 25px;
        border: 2px solid transparent;
    }

    .debit-display {
        border-color: rgba(16, 185, 129, 0.3);
    }

    .kredit-display {
        border-color: rgba(239, 68, 68, 0.3);
    }

    .display-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        font-weight: 600;
        font-size: 18px;
    }

    .debit-display .display-title {
        color: #10b981;
    }

    .kredit-display .display-title {
        color: #ef4444;
    }

    .display-title i {
        font-size: 24px;
    }

    .akun-name {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 15px;
    }

    .amount-display {
        font-size: 32px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
    }

    .debit-display .amount-display {
        color: #10b981;
    }

    .kredit-display .amount-display {
        color: #ef4444;
    }

    /* Balance Display */
    .balance-display {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .balance-display h4 {
        margin: 0 0 15px 0;
        color: #60a5fa;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .balance-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
    }

    .balance-status.balanced {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }

    .balance-status.unbalanced {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .balance-status i {
        font-size: 18px;
    }

    /* Jurnal Entry Preview */
    .jurnal-preview {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .jurnal-preview h4 {
        margin: 0 0 20px 0;
        color: white;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .entry-row {
        display: flex;
        padding: 12px 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .entry-row.debit {
        border-left: 3px solid #10b981;
    }

    .entry-row.kredit {
        border-left: 3px solid #ef4444;
    }

    .entry-akun {
        flex: 1;
        font-weight: 500;
        color: white;
    }

    .entry-kredit .entry-akun {
        padding-left: 30px;
    }

    .entry-amount {
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
    }

    .entry-row.debit .entry-amount {
        color: #10b981;
    }

    .entry-row.kredit .entry-amount {
        color: #ef4444;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid rgba(255,255,255,0.1);
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

    .btn-primary {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(6, 182, 212, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.6);
    }

    .btn-warning {
        background: linear-gradient(135deg, #ec4899, #db2777);
        color: white;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
    }

    .btn-secondary {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.2);
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .detail-card {
            padding: 20px;
        }

        .info-grid,
        .transaction-display {
            grid-template-columns: 1fr;
        }

        .detail-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .detail-actions {
            width: 100%;
        }
    }
</style>

<div class="detail-card">
    <div class="detail-header">
        <div class="header-left">
            <i class='bx bx-file'></i>
            <h2>Detail Jurnal Umum</h2>
        </div>
        <div class="detail-actions">
            <a href="{{ route('jurnal-umum.edit', $jurnal->id) }}" class="btn btn-warning btn-sm">
                <i class='bx bx-edit'></i> Edit
            </a>
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <h3><i class='bx bx-info-circle'></i> Informasi Transaksi</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">ID Jurnal</span>
                <span class="info-value">#{{ str_pad($jurnal->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Transaksi</span>
                <span class="info-value">{{ $jurnal->tanggal->format('d F Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Dibuat Pada</span>
                <span class="info-value">{{ $jurnal->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Terakhir Update</span>
                <span class="info-value">{{ $jurnal->updated_at->format('d M Y H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Keterangan Section -->
    <div class="keterangan-section">
        <h3><i class='bx bx-note'></i> Keterangan</h3>
        <p class="keterangan-text">{{ $jurnal->keterangan }}</p>
    </div>

    <!-- Transaction Display -->
    <div class="transaction-display">
        <!-- DEBIT -->
        <div class="debit-display">
            <div class="display-title">
                <i class='bx bx-plus-circle'></i>
                DEBIT
            </div>
            <div class="akun-name">{{ $jurnal->akun_debit }}</div>
            <div class="amount-display">Rp {{ number_format($jurnal->debit, 0, ',', '.') }}</div>
        </div>

        <!-- KREDIT -->
        <div class="kredit-display">
            <div class="display-title">
                <i class='bx bx-minus-circle'></i>
                KREDIT
            </div>
            <div class="akun-name">{{ $jurnal->akun_kredit }}</div>
            <div class="amount-display">Rp {{ number_format($jurnal->kredit, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Balance Status -->
    <div class="balance-display">
        <h4><i class='bx bx-calculator'></i> Status Balance</h4>
        @if($jurnal->debit == $jurnal->kredit)
            <span class="balance-status balanced">
                <i class='bx bx-check-circle'></i>
                Balanced (Debit = Kredit)
            </span>
        @else
            <span class="balance-status unbalanced">
                <i class='bx bx-error-circle'></i>
                Unbalanced (Selisih: Rp {{ number_format(abs($jurnal->debit - $jurnal->kredit), 0, ',', '.') }})
            </span>
        @endif
    </div>

    <!-- Jurnal Entry Preview -->
    <div class="jurnal-preview">
        <h4><i class='bx bx-book'></i> Preview Jurnal Entry</h4>
        <div class="entry-row debit">
            <span class="entry-akun">{{ $jurnal->akun_debit }}</span>
            <span class="entry-amount">Rp {{ number_format($jurnal->debit, 0, ',', '.') }}</span>
        </div>
        <div class="entry-row kredit">
            <span class="entry-akun">{{ $jurnal->akun_kredit }}</span>
            <span class="entry-amount">Rp {{ number_format($jurnal->kredit, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('jurnal-umum.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
        <a href="{{ route('jurnal-umum.edit', $jurnal->id) }}" class="btn btn-primary">
            <i class='bx bx-edit'></i> Edit Jurnal
        </a>
    </div>
</div>

@endsection