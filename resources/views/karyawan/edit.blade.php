@extends('layouts.main')

@section('page-title', 'Edit Karyawan')

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
</style>

<div class="form-card">
    <div class="form-header">
        <i class='bx bx-edit'></i>
        <h2>Edit Karyawan</h2>
    </div>

    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="id_karyawan">ID Karyawan</label>
                <div class="id-badge">
                    <i class='bx bx-id-card'></i>
                    {{ $karyawan->id_karyawan }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nama_karyawan">Nama Karyawan <span style="color: #dc2626;">*</span></label>
                <input 
                    type="text" 
                    id="nama_karyawan" 
                    name="nama_karyawan" 
                    value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}"
                    placeholder="Contoh: Amanda Putri"
                    required
                >
                @error('nama_karyawan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jabatan">Jabatan <span style="color: #dc2626;">*</span></label>
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
        </div>

        <div class="form-actions">
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-check'></i> Update Data
            </button>
        </div>
    </form>
</div>

@endsection