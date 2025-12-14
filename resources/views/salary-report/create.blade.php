@extends('layouts.main')

@section('page-title', 'Buat Salary Report')

@section('content')

<style>
    .form-card {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-header i {
        font-size: 32px;
        color: #3b82f6;
    }

    .form-header h2 {
        margin: 0;
        font-size: 24px;
        color: #1f2937;
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
        color: #374151;
        font-size: 14px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px 15px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
        color: #1f2937;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group select option {
        background: white;
        color: #1f2937;
        padding: 10px;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #9ca3af;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
    }

    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
        color: #1e40af;
        font-size: 13px;
        line-height: 1.6;
    }

    .info-box strong {
        color: #1d4ed8;
    }

    .calculation-preview {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .calculation-preview h4 {
        margin: 0 0 15px 0;
        color: #16a34a;
        font-size: 16px;
        font-weight: 600;
    }

    .calc-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: #374151;
        font-size: 14px;
    }

    .calc-item.total {
        border-top: 1px solid #bbf7d0;
        margin-top: 10px;
        padding-top: 15px;
        font-size: 18px;
        font-weight: 700;
        color: #16a34a;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.15);
    }

    .btn-secondary {
        background: white;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
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
        <i class='bx bx-wallet'></i>
        <h2>Buat Salary Report Baru</h2>
    </div>

    <div class="info-box">
        <strong>💡 Info:</strong> Total gaji dihitung otomatis dengan rumus: 
        <strong>(Gaji/Jam × Lama Bekerja) + Bonus</strong>. 
        Status awal akan diset sebagai "Menunggu Pembayaran".
    </div>

    <form action="{{ route('salary-report.store') }}" method="POST" id="salaryForm">
        @csrf

        <div class="form-row">
            <div class="form-group full-width">
                <label for="karyawan_id">Pilih Karyawan <span style="color: #ef4444;">*</span></label>
                <select id="karyawan_id" name="karyawan_id" required onchange="getKaryawanData()">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}" {{ old('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
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
                <label for="tanggal">Tanggal <span style="color: #ef4444;">*</span></label>
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
                <label for="gaji_per_jam">Gaji per Jam <span style="color: #ef4444;">*</span></label>
                <input 
                    type="number" 
                    id="gaji_per_jam" 
                    name="gaji_per_jam" 
                    value="{{ old('gaji_per_jam') }}"
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
                <label for="lama_bekerja">Lama Bekerja (Jam) <span style="color: #ef4444;">*</span></label>
                <input 
                    type="number" 
                    id="lama_bekerja" 
                    name="lama_bekerja" 
                    value="{{ old('lama_bekerja') }}"
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
                    value="{{ old('bonus', 0) }}"
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
                >{{ old('keterangan') }}</textarea>
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
                <i class='bx bx-check'></i> Simpan Report
            </button>
        </div>
    </form>
</div>

<script>
// Get Karyawan Data via AJAX
function getKaryawanData() {
    const karyawanId = document.getElementById('karyawan_id').value;
    
    if (!karyawanId) {
        return;
    }

    fetch(`/get-karyawan/${karyawanId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Karyawan:', data.data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

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
    getKaryawanData();
}
</script>

@endsection