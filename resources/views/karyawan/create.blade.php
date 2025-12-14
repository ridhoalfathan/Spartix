@extends('layouts.main')

@section('page-title', 'Tambah Karyawan')

@section('content')

<style>
    .form-card {
        background: rgba(255,255,255,0.95);
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        max-width: 900px;
        margin: 0 auto;
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .form-header i {
        font-size: 32px;
        color: #2563eb;
    }

    .form-header h2 {
        margin: 0;
        font-size: 24px;
        color: #1e3a8a;
        font-weight: 700;
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
        font-weight: 600;
        color: #1e3a8a;
        font-size: 14px;
    }

    .form-group input,
    .form-group select {
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: #1e3a8a;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        transition: 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #2563eb;
        background: #f8fafc;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-group select option {
        background: white;
        color: #1e3a8a;
        padding: 10px;
    }

    .form-group input::placeholder {
        color: #94a3b8;
    }

    .form-group input[readonly] {
        background: #f1f5f9;
        color: #2563eb;
        font-weight: 600;
        border-color: #cbd5e1;
        cursor: not-allowed;
    }

    .id-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .id-badge i {
        font-size: 20px;
    }

    .error-message {
        color: #dc2626;
        font-size: 12px;
        margin-top: 5px;
        font-weight: 500;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #e2e8f0;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 600;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 2px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .info-box {
        background: #dbeafe;
        border-left: 4px solid #2563eb;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-box i {
        font-size: 20px;
        color: #2563eb;
    }

    .info-box p {
        margin: 0;
        color: #1e40af;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-card">
    <div class="form-header">
        <i class='bx bx-user-plus'></i>
        <h2>Tambah Karyawan Baru</h2>
    </div>

    <div class="info-box">
        <i class='bx bx-info-circle'></i>
        <p>ID Karyawan akan dibuat otomatis oleh sistem</p>
    </div>

    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group full-width">
                <label for="id_karyawan">ID Karyawan (Otomatis)</label>
                <div class="id-badge">
                    <i class='bx bx-id-card'></i>
                    {{ App\Models\Karyawan::generateIdKaryawan() }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label for="nama_karyawan">Nama Karyawan <span style="color: #dc2626;">*</span></label>
                <input 
                    type="text" 
                    id="nama_karyawan" 
                    name="nama_karyawan" 
                    value="{{ old('nama_karyawan') }}"
                    placeholder="Contoh: Amanda Putri"
                    required
                >
                @error('nama_karyawan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label for="jabatan">Jabatan <span style="color: #dc2626;">*</span></label>
                <select id="jabatan" name="jabatan" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="Admin" {{ old('jabatan') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Produksi" {{ old('jabatan') == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                    <option value="Packing" {{ old('jabatan') == 'Packing' ? 'selected' : '' }}>Packing</option>
                    <option value="Pengirim" {{ old('jabatan') == 'Pengirim' ? 'selected' : '' }}>Pengirim</option>
                    <option value="Finishing" {{ old('jabatan') == 'Finishing' ? 'selected' : '' }}>Finishing</option>
                </select>
                @error('jabatan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-check'></i> Simpan Data
            </button>
        </div>
    </form>
</div>

@endsection