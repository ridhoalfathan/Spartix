@extends('layouts.main')

@section('page-title', 'Edit Karyawan')

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
        color: #f093fb;
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

    .form-group label {
        margin-bottom: 8px;
        font-weight: 500;
        color: rgba(255,255,255,0.9);
        font-size: 14px;
    }

    .form-group input,
    .form-group select {
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
    .form-group select:focus {
        outline: none;
        border-color: #f093fb;
        background: rgba(255,255,255,0.15);
        box-shadow: 0 0 0 3px rgba(240, 147, 251, 0.2);
    }

    .form-group select option {
        background: #1a2332;
        color: white;
        padding: 10px;
    }

    .form-group input::placeholder {
        color: rgba(255,255,255,0.5);
    }

    .error-message {
        color: #ff6b6b;
        font-size: 12px;
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
    }

    .btn-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(240, 147, 251, 0.6);
    }

    .btn-secondary {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.2);
    }

    .full-width {
        grid-column: 1 / -1;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-card">
    <div class="form-header">
        <i class='bx bx-edit'></i>
        <h2>Edit Data Karyawan</h2>
    </div>

    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="id_karyawan">ID Karyawan <span style="color: #ff6b6b;">*</span></label>
                <input 
                    type="text" 
                    id="id_karyawan" 
                    name="id_karyawan" 
                    value="{{ old('id_karyawan', $karyawan->id_karyawan) }}"
                    placeholder="Contoh: 125893"
                    required
                >
                @error('id_karyawan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_karyawan">Nama Karyawan <span style="color: #ff6b6b;">*</span></label>
                <input 
                    type="text" 
                    id="nama_karyawan" 
                    name="nama_karyawan" 
                    value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}"
                    placeholder="Contoh: Amanda"
                    required
                >
                @error('nama_karyawan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jabatan">Jabatan <span style="color: #ff6b6b;">*</span></label>
                <select id="jabatan" name="jabatan" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="Admin" {{ old('jabatan', $karyawan->jabatan) == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Produksi" {{ old('jabatan', $karyawan->jabatan) == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                    <option value="Packing" {{ old('jabatan', $karyawan->jabatan) == 'Packing' ? 'selected' : '' }}>Packing</option>
                    <option value="Pengirim" {{ old('jabatan', $karyawan->jabatan) == 'Pengirim' ? 'selected' : '' }}>Pengirim</option>
                    <option value="Finishing" {{ old('jabatan', $karyawan->jabatan) == 'Finishing' ? 'selected' : '' }}>Finishing</option>
                </select>
                @error('jabatan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori <span style="color: #ff6b6b;">*</span></label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Mencatat Laporan" {{ old('kategori', $karyawan->kategori) == 'Mencatat Laporan' ? 'selected' : '' }}>Mencatat Laporan</option>
                    <option value="Besar" {{ old('kategori', $karyawan->kategori) == 'Besar' ? 'selected' : '' }}>Besar</option>
                    <option value="Sedang" {{ old('kategori', $karyawan->kategori) == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Kecil" {{ old('kategori', $karyawan->kategori) == 'Kecil' ? 'selected' : '' }}>Kecil</option>
                </select>
                @error('kategori')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label for="hasil">Hasil (Opsional)</label>
                <input 
                    type="text" 
                    id="hasil" 
                    name="hasil" 
                    value="{{ old('hasil', $karyawan->hasil) }}"
                    placeholder="Contoh: Laporan"
                >
                @error('hasil')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Batal
            </a>
            <button type="submit" class="btn btn-warning">
                <i class='bx bx-save'></i> Update Data
            </button>
        </div>
    </form>
</div>

@endsection