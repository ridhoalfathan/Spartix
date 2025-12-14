@extends('layouts.main')

@section('page-title', 'Edit Akun Buku Besar')

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
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-header h2 {
        margin: 0;
        font-size: 24px;
        color: white;
    }

    .info-box {
        background: rgba(236, 72, 153, 0.1);
        border: 1px solid rgba(236, 72, 153, 0.3);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
    }

    .info-box strong {
        color: #f472b6;
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
        min-height: 80px;
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

    .error-message {
        color: #ff6b6b;
        font-size: 12px;
        margin-top: 5px;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .checkbox-group:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .checkbox-group input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #ec4899;
    }

    .checkbox-group label {
        margin: 0;
        cursor: pointer;
        color: rgba(255, 255, 255, 0.9);
    }

    .helper-text {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        margin-top: 5px;
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
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
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
        <h2>Edit Akun Buku Besar</h2>
    </div>

    <div class="info-box">
        <strong>✏️ Edit Mode:</strong> Perubahan pada akun ini akan mempengaruhi perhitungan saldo pada transaksi yang sudah ada.
    </div>

    <form action="{{ route('buku-besar.update', $bukuBesar->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="kode_akun">Kode Akun <span style="color: #ff6b6b;">*</span></label>
                <input 
                    type="text" 
                    id="kode_akun" 
                    name="kode_akun" 
                    value="{{ old('kode_akun', $bukuBesar->kode_akun) }}"
                    placeholder="Contoh: 1101"
                    required
                >
                <span class="helper-text">Kode unik untuk identifikasi akun</span>
                @error('kode_akun')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_akun">Nama Akun <span style="color: #ff6b6b;">*</span></label>
                <input 
                    type="text" 
                    id="nama_akun" 
                    name="nama_akun" 
                    value="{{ old('nama_akun', $bukuBesar->nama_akun) }}"
                    placeholder="Contoh: Kas"
                    required
                >
                @error('nama_akun')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jenis_akun">Jenis Akun <span style="color: #ff6b6b;">*</span></label>
                <select id="jenis_akun" name="jenis_akun" required>
                    <option value="">-- Pilih Jenis Akun --</option>
                    <option value="Aset" {{ old('jenis_akun', $bukuBesar->jenis_akun) == 'Aset' ? 'selected' : '' }}>Aset</option>
                    <option value="Liabilitas" {{ old('jenis_akun', $bukuBesar->jenis_akun) == 'Liabilitas' ? 'selected' : '' }}>Liabilitas</option>
                    <option value="Ekuitas" {{ old('jenis_akun', $bukuBesar->jenis_akun) == 'Ekuitas' ? 'selected' : '' }}>Ekuitas</option>
                    <option value="Pendapatan" {{ old('jenis_akun', $bukuBesar->jenis_akun) == 'Pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                    <option value="Beban" {{ old('jenis_akun', $bukuBesar->jenis_akun) == 'Beban' ? 'selected' : '' }}>Beban</option>
                </select>
                @error('jenis_akun')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="posisi_normal">Posisi Normal <span style="color: #ff6b6b;">*</span></label>
                <select id="posisi_normal" name="posisi_normal" required>
                    <option value="">-- Pilih Posisi Normal --</option>
                    <option value="Debit" {{ old('posisi_normal', $bukuBesar->posisi_normal) == 'Debit' ? 'selected' : '' }}>Debit</option>
                    <option value="Kredit" {{ old('posisi_normal', $bukuBesar->posisi_normal) == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                </select>
                <span class="helper-text">Aset & Beban: Debit | Liabilitas, Ekuitas & Pendapatan: Kredit</span>
                @error('posisi_normal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="saldo_awal">Saldo Awal</label>
                <input 
                    type="number" 
                    id="saldo_awal" 
                    name="saldo_awal" 
                    value="{{ old('saldo_awal', $bukuBesar->saldo_awal) }}"
                    placeholder="Contoh: 10000000"
                    step="0.01"
                    min="0"
                >
                <span class="helper-text">Saldo awal akun (opsional)</span>
                @error('saldo_awal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Status Akun</label>
                <div class="checkbox-group">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $bukuBesar->is_active) ? 'checked' : '' }}
                    >
                    <label for="is_active">Akun Aktif</label>
                </div>
                <span class="helper-text">Centang jika akun akan digunakan</span>
            </div>
        </div>

        <div class="form-group full-width">
            <label for="keterangan">Keterangan</label>
            <textarea 
                id="keterangan" 
                name="keterangan" 
                placeholder="Deskripsi atau catatan tentang akun ini"
            >{{ old('keterangan', $bukuBesar->keterangan) }}</textarea>
            @error('keterangan')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('buku-besar.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-check'></i> Update Akun
            </button>
        </div>
    </form>
</div>

@endsection