@extends('layouts.main')

@section('page-title', 'Edit Jurnal Umum')

@section('content')

<style>
    .form-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(15px);
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        max-width: 900px;
        margin: 0 auto;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(255,255,255,0.2);
    }

    .form-header i {
        font-size: 32px;
        background: linear-gradient(135deg, #ec4899, #db2777);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-header h2 {
        margin: 0;
        font-size: 24px;
        color: white;
    }

    .info-box {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
        line-height: 1.6;
    }

    .info-box strong {
        color: #60a5fa;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ff6b6b;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        margin-bottom: 8px;
        font-weight: 500;
        color: rgba(255,255,255,0.9);
        font-size: 14px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px 15px;
        border: 2px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        background: rgba(255,255,255,0.1);
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        transition: 0.3s;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ec4899;
        background: rgba(255,255,255,0.15);
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
    }

    .form-group select {
        cursor: pointer;
    }

    .form-group select option {
        background: #1a2332;
        color: white;
        padding: 10px;
    }

    .form-group select optgroup {
        background: #0f1419;
        color: #60a5fa;
        font-weight: 600;
        font-size: 13px;
        padding: 8px;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: rgba(255,255,255,0.5);
    }

    .error-message {
        color: #ff6b6b;
        font-size: 12px;
        margin-top: 5px;
    }

    /* Debit & Kredit Section */
    .transaction-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .debit-section,
    .kredit-section {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        border: 2px solid transparent;
        transition: all 0.3s;
    }

    .debit-section {
        border-color: rgba(16, 185, 129, 0.3);
    }

    .kredit-section {
        border-color: rgba(239, 68, 68, 0.3);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        font-weight: 600;
        font-size: 16px;
    }

    .debit-section .section-title {
        color: #10b981;
    }

    .kredit-section .section-title {
        color: #ef4444;
    }

    .section-title i {
        font-size: 20px;
    }

    /* Balance Preview */
    .balance-preview {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .balance-preview h4 {
        margin: 0 0 15px 0;
        color: #60a5fa;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .balance-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
    }

    .balance-item.debit strong {
        color: #10b981;
    }

    .balance-item.kredit strong {
        color: #ef4444;
    }

    .balance-item.balanced {
        border-top: 2px solid rgba(59, 130, 246, 0.3);
        margin-top: 10px;
        padding-top: 15px;
        font-size: 16px;
        font-weight: 600;
    }

    .balance-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
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
        background: linear-gradient(135deg, #ec4899, #db2777);
        color: white;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(236, 72, 153, 0.6);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .btn-secondary {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.2);
    }

    .required {
        color: #ff6b6b;
    }

    @media (max-width: 768px) {
        .form-row,
        .transaction-section {
            grid-template-columns: 1fr;
        }

        .form-card {
            padding: 20px;
        }
    }
</style>

<div class="form-card">
    <div class="form-header">
        <i class='bx bx-edit'></i>
        <h2>Edit Jurnal Umum</h2>
    </div>

    @if(session('error'))
    <div class="alert alert-error">
        <i class='bx bx-error-circle'></i>
        {{ session('error') }}
    </div>
    @endif

    <div class="info-box">
        <strong>💡 Panduan:</strong> 
        <ul style="margin: 8px 0 0 20px; padding: 0;">
            <li>Pilih akun debit dan kredit dari daftar yang tersedia</li>
            <li>Pastikan nilai Debit dan Kredit <strong>seimbang (balance)</strong></li>
            <li>Akun debit dan kredit tidak boleh sama</li>
        </ul>
    </div>

    <form action="{{ route('jurnal-umum.update', $jurnal->id) }}" method="POST" id="jurnalForm">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="tanggal">Tanggal Transaksi <span class="required">*</span></label>
                <input 
                    type="date" 
                    id="tanggal" 
                    name="tanggal" 
                    value="{{ old('tanggal', $jurnal->tanggal->format('Y-m-d')) }}"
                    required
                >
                @error('tanggal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Status Balance</label>
                <div id="balance_status_display" style="padding: 12px 15px;">
                    <span class="balance-status balanced">
                        <i class='bx bx-check-circle'></i> Balanced
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group full-width">
            <label for="keterangan">Keterangan Transaksi <span class="required">*</span></label>
            <textarea 
                id="keterangan" 
                name="keterangan" 
                placeholder="Contoh: Pembayaran gaji karyawan bulan Desember"
                required
            >{{ old('keterangan', $jurnal->keterangan) }}</textarea>
            @error('keterangan')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Debit & Kredit Section -->
        <div class="transaction-section">
            <!-- DEBIT -->
            <div class="debit-section">
                <div class="section-title">
                    <i class='bx bx-plus-circle'></i>
                    DEBIT
                </div>
                <div class="form-group">
                    <label for="akun_debit">Akun Debit <span class="required">*</span></label>
                    <select 
                        id="akun_debit" 
                        name="akun_debit" 
                        required
                    >
                        <option value="">-- Pilih Akun Debit --</option>
                        @foreach($akuns as $kategori => $daftarAkun)
                            <optgroup label="{{ $kategori }}">
                                @foreach($daftarAkun as $key => $value)
                                    <option value="{{ $value }}" {{ old('akun_debit', $jurnal->akun_debit) == $value ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('akun_debit')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="debit">Nominal Debit <span class="required">*</span></label>
                    <input 
                        type="number" 
                        id="debit" 
                        name="debit" 
                        value="{{ old('debit', $jurnal->debit) }}"
                        placeholder="Contoh: 5000000"
                        step="0.01"
                        min="0"
                        required
                        oninput="checkBalance()"
                    >
                    @error('debit')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- KREDIT -->
            <div class="kredit-section">
                <div class="section-title">
                    <i class='bx bx-minus-circle'></i>
                    KREDIT
                </div>
                <div class="form-group">
                    <label for="akun_kredit">Akun Kredit <span class="required">*</span></label>
                    <select 
                        id="akun_kredit" 
                        name="akun_kredit" 
                        required
                    >
                        <option value="">-- Pilih Akun Kredit --</option>
                        @foreach($akuns as $kategori => $daftarAkun)
                            <optgroup label="{{ $kategori }}">
                                @foreach($daftarAkun as $key => $value)
                                    <option value="{{ $value }}" {{ old('akun_kredit', $jurnal->akun_kredit) == $value ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('akun_kredit')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="kredit">Nominal Kredit <span class="required">*</span></label>
                    <input 
                        type="number" 
                        id="kredit" 
                        name="kredit" 
                        value="{{ old('kredit', $jurnal->kredit) }}"
                        placeholder="Contoh: 5000000"
                        step="0.01"
                        min="0"
                        required
                        oninput="checkBalance()"
                    >
                    @error('kredit')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Balance Preview -->
        <div class="balance-preview">
            <h4><i class='bx bx-calculator'></i> Preview Balance</h4>
            <div class="balance-item debit">
                <span>Total Debit:</span>
                <strong id="preview_debit">Rp 0</strong>
            </div>
            <div class="balance-item kredit">
                <span>Total Kredit:</span>
                <strong id="preview_kredit">Rp 0</strong>
            </div>
            <div class="balance-item balanced">
                <span>Selisih:</span>
                <strong id="preview_selisih" style="color: #60a5fa;">Rp 0</strong>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('jurnal-umum.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class='bx bx-check'></i> Update Jurnal
            </button>
        </div>
    </form>
</div>

<script>
// Format number to Rupiah
function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
}

// Check Balance
function checkBalance() {
    const debit = parseFloat(document.getElementById('debit').value) || 0;
    const kredit = parseFloat(document.getElementById('kredit').value) || 0;
    const selisih = Math.abs(debit - kredit);
    
    // Update preview
    document.getElementById('preview_debit').textContent = formatRupiah(debit);
    document.getElementById('preview_kredit').textContent = formatRupiah(kredit);
    document.getElementById('preview_selisih').textContent = formatRupiah(selisih);
    
    // Update status
    const statusDisplay = document.getElementById('balance_status_display');
    
    if (debit === kredit && debit > 0) {
        statusDisplay.innerHTML = '<span class="balance-status balanced"><i class="bx bx-check-circle"></i> Balanced</span>';
        document.getElementById('preview_selisih').style.color = '#10b981';
    } else {
        statusDisplay.innerHTML = '<span class="balance-status unbalanced"><i class="bx bx-error-circle"></i> Unbalanced</span>';
        document.getElementById('preview_selisih').style.color = '#ef4444';
    }
}

// Validasi sebelum submit
document.getElementById('jurnalForm').addEventListener('submit', function(e) {
    const debit = parseFloat(document.getElementById('debit').value) || 0;
    const kredit = parseFloat(document.getElementById('kredit').value) || 0;
    const akunDebit = document.getElementById('akun_debit').value;
    const akunKredit = document.getElementById('akun_kredit').value;
    
    // Cek balance
    if (debit !== kredit) {
        e.preventDefault();
        alert('⚠️ Debit dan Kredit harus seimbang!\n\nDebit: ' + formatRupiah(debit) + '\nKredit: ' + formatRupiah(kredit));
        return false;
    }
    
    // Cek akun sama
    if (akunDebit === akunKredit) {
        e.preventDefault();
        alert('⚠️ Akun Debit dan Kredit tidak boleh sama!');
        return false;
    }
});

// Auto check on page load
window.onload = function() {
    checkBalance();
}
</script>

@endsection