@extends('layouts.main')

@section('page-title', 'Edit Salary Report')

@section('content')

<style>
    .form-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(15px);
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        max-width: 800px;
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

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ec4899;
        background: rgba(255,255,255,0.15);
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
    }

    .form-group select option {
        background: #1a2332;
        color: white;
        padding: 10px;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: rgba(255,255,255,0.5);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .form-group input[readonly] {
        background: rgba(255,255,255,0.05);
        cursor: not-allowed;
        border-color: rgba(255,255,255,0.1);
    }

    .error-message {
        color: #ff6b6b;
        font-size: 12px;
        margin-top: 5px;
    }

    .info-box {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
    }

    .info-box strong {
        color: #60a5fa;
    }

    .warning-box {
        background: rgba(251, 191, 36, 0.1);
        border: 1px solid rgba(251, 191, 36, 0.3);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
    }

    .warning-box strong {
        color: #fbbf24;
    }

    .calculation-preview {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .calculation-preview h4 {
        margin: 0 0 15px 0;
        color: #34d399;
        font-size: 16px;
    }

    .calc-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
    }

    .calc-item.total {
        border-top: 2px solid rgba(16, 185, 129, 0.3);
        margin-top: 10px;
        padding-top: 15px;
        font-size: 18px;
        font-weight: 700;
        color: #34d399;
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

    .btn-secondary {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.2);
    }

    @media (max-width: 768px) {
        .form-row {
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
        <h2>Edit Salary Report</h2>
    </div>

    @if($salaryReport->status === 'paid')
    <div class="warning-box">
        <strong>⚠️ Peringatan:</strong> Report ini sudah ditandai sebagai "Dibayar". 
        Edit data akan mempengaruhi jurnal yang sudah dibuat.
    </div>
    @else
    <div class="info-box">
        <strong>💡 Info:</strong> Total gaji dihitung otomatis dengan rumus: 
        <strong>(Gaji/Jam × Lama Bekerja) + Bonus</strong>
    </div>
    @endif

    <form action="{{ route('salary-report.update', $salaryReport->id) }}" method="POST" id="salaryForm">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group full-width">
                <label for="karyawan_id">Karyawan <span style="color: #ff6b6b;">*</span></label>
                <select id="karyawan_id" name="karyawan_id" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}" {{ $salaryReport->karyawan_id == $karyawan->id ? 'selected' : '' }}>
                            {{ $karyawan->id_karyawan }} - {{ $karyawan->nama_karyawan }} ({{ $karyawan->jabatan }})
                        </option>
                    @endforeach
                </select>
                @error('karyawan_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tanggal">Tanggal <span style="color: #ff6b6b;">*</span></label>
                <input 
                    type="date" 
                    id="tanggal" 
                    name="tanggal" 
                    value="{{ old('tanggal', $salaryReport->tanggal->format('Y-m-d')) }}"
                    required
                >
                @error('tanggal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="gaji_per_jam">Gaji per Jam <span style="color: #ff6b6b;">*</span></label>
                <input 
                    type="number" 
                    id="gaji_per_jam" 
                    name="gaji_per_jam" 
                    value="{{ old('gaji_per_jam', $salaryReport->gaji_per_jam) }}"
                    placeholder="Contoh: 50000"
                    step="0.01"
                    min="0"
                    required
                    oninput="calculateTotal()"
                >
                @error('gaji_per_jam')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="lama_bekerja">Lama Bekerja (Jam) <span style="color: #ff6b6b;">*</span></label>
                <input 
                    type="number" 
                    id="lama_bekerja" 
                    name="lama_bekerja" 
                    value="{{ old('lama_bekerja', $salaryReport->lama_bekerja) }}"
                    placeholder="Contoh: 8 atau 8.5"
                    step="0.01"
                    min="0"
                    required
                    oninput="calculateTotal()"
                >
                @error('lama_bekerja')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="bonus">Bonus</label>
                <input 
                    type="number" 
                    id="bonus" 
                    name="bonus" 
                    value="{{ old('bonus', $salaryReport->bonus) }}"
                    placeholder="Contoh: 100000"
                    step="0.01"
                    min="0"
                    oninput="calculateTotal()"
                >
                @error('bonus')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label for="keterangan">Keterangan (Optional)</label>
                <textarea 
                    id="keterangan" 
                    name="keterangan" 
                    placeholder="Tambahkan catatan jika diperlukan..."
                >{{ old('keterangan', $salaryReport->keterangan) }}</textarea>
                @error('keterangan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="calculation-preview">
            <h4>💰 Preview Perhitungan</h4>
            <div class="calc-item">
                <span>Gaji per Jam:</span>
                <strong id="preview_gaji">Rp 0</strong>
            </div>
            <div class="calc-item">
                <span>Lama Bekerja:</span>
                <strong id="preview_jam">0 jam</strong>
            </div>
            <div class="calc-item">
                <span>Subtotal (Gaji × Jam):</span>
                <strong id="preview_subtotal">Rp 0</strong>
            </div>
            <div class="calc-item">
                <span>Bonus:</span>
                <strong id="preview_bonus">Rp 0</strong>
            </div>
            <div class="calc-item total">
                <span>TOTAL:</span>
                <strong id="preview_total">Rp 0</strong>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('salary-report.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-check'></i> Update Report
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

// Calculate Total
function calculateTotal() {
    const gajiPerJam = parseFloat(document.getElementById('gaji_per_jam').value) || 0;
    const lamaBekerja = parseFloat(document.getElementById('lama_bekerja').value) || 0;
    const bonus = parseFloat(document.getElementById('bonus').value) || 0;
    
    const subtotal = gajiPerJam * lamaBekerja;
    const total = subtotal + bonus;
    
    // Update preview
    document.getElementById('preview_gaji').textContent = formatRupiah(gajiPerJam);
    document.getElementById('preview_jam').textContent = lamaBekerja + ' jam';
    document.getElementById('preview_subtotal').textContent = formatRupiah(subtotal);
    document.getElementById('preview_bonus').textContent = formatRupiah(bonus);
    document.getElementById('preview_total').textContent = formatRupiah(total);
}

// Auto calculate on page load
window.onload = function() {
    calculateTotal();
}
</script>

@endsection