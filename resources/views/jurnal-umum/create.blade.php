@extends('layouts.main')

@section('page-title', 'Tambah Jurnal Umum')

@section('content')

<style>
    .form-card {
        background: rgba(255, 255, 255, 0.95);
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: 0 auto;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(37, 99, 235, 0.15);
    }

    .form-header i {
        font-size: 32px;
        color: #2563eb;
    }

    .form-header h2 {
        margin: 0;
        font-size: 24px;
        color: #1e3a8a;
    }

    .info-box {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
        color: #1e3a8a;
        font-size: 13px;
        line-height: 1.6;
    }

    .info-box strong {
        color: #2563eb;
    }

    .info-box ul {
        margin: 8px 0 0 20px;
        padding: 0;
        color: #334155;
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
        color: #dc2626;
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
        font-weight: 600;
        color: #1e3a8a;
        font-size: 14px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px 15px;
        border: 2px solid rgba(37, 99, 235, 0.2);
        border-radius: 8px;
        background: rgba(37, 99, 235, 0.05);
        color: #1e3a8a;
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
        border-color: #2563eb;
        background: rgba(37, 99, 235, 0.08);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-group select {
        cursor: pointer;
    }

    .form-group select option {
        background: white;
        color: #1e3a8a;
        padding: 10px;
    }

    .form-group select optgroup {
        background: #f8fafc;
        color: #2563eb;
        font-weight: 600;
        font-size: 13px;
        padding: 8px;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #94a3b8;
    }

    .error-message {
        color: #dc2626;
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
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 2px solid;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .debit-section {
        border-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.03), rgba(5, 150, 105, 0.03));
    }

    .kredit-section {
        border-color: #ef4444;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.03), rgba(220, 38, 38, 0.03));
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
        background: rgba(37, 99, 235, 0.05);
        border: 1px solid rgba(37, 99, 235, 0.2);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .balance-preview h4 {
        margin: 0 0 15px 0;
        color: #2563eb;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .balance-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: #334155;
        font-size: 14px;
    }

    .balance-item.debit strong {
        color: #10b981;
    }

    .balance-item.kredit strong {
        color: #ef4444;
    }

    .balance-item.balanced {
        border-top: 2px solid rgba(37, 99, 235, 0.2);
        margin-top: 10px;
        padding-top: 15px;
        font-size: 16px;
        font-weight: 600;
        color: #1e3a8a;
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
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .balance-status.unbalanced {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid rgba(37, 99, 235, 0.1);
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
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 2px solid #cbd5e1;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .required {
        color: #ef4444;
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
        <i class='bx bx-plus-circle'></i>
        <h2>Tambah Jurnal Umum Baru</h2>
    </div>

    @if(session('error'))
    <div class="alert alert-error">
        <i class='bx bx-error-circle'></i>
        {{ session('error') }}
    </div>
    @endif

    <div class="info-box">
        <strong>💡 Panduan:</strong> 
        <ul>
            <li>Pilih akun debit dan kredit dari daftar yang tersedia</li>
            <li>Pastikan nilai Debit dan Kredit <strong>seimbang (balance)</strong></li>
            <li>Akun debit dan kredit tidak boleh sama</li>
        </ul>
    </div>

    <form action="{{ route('jurnal-umum.store') }}" method="POST" id="jurnalForm">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="tanggal">Tanggal Transaksi <span class="required">*</span></label>
                <input 
                    type="date" 
                    id="tanggal" 
                    name="tanggal" 
                    value="{{ old('tanggal', date('Y-m-d')) }}"
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
            >{{ old('keterangan') }}</textarea>
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
                                    <option value="{{ $value }}" {{ old('akun_debit') == $value ? 'selected' : '' }}>
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
                        value="{{ old('debit') }}"
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
                                    <option value="{{ $value }}" {{ old('akun_kredit') == $value ? 'selected' : '' }}>
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
                        value="{{ old('kredit') }}"
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
                <strong id="preview_selisih" style="color: #2563eb;">Rp 0</strong>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('jurnal-umum.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class='bx bx-check'></i> Simpan Jurnal
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