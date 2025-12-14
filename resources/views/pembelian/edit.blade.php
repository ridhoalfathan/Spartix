@extends('layouts.main')

@section('page-title', 'Edit Pembelian')

@section('content')

<style>
    .page-container {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 1200px;
        margin: 0 auto;
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
    }

    .form-header i {
        font-size: 32px;
        color: #f59e0b;
    }

    .form-header h2 {
        margin: 0;
        font-size: 24px;
        color: #1e293b;
        font-weight: 600;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
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
        color: #334155;
        font-size: 14px;
    }

    .form-group label .required {
        color: #ef4444;
    }

    .form-group input,
    .form-group select {
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: white;
        color: #1e293b;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        transition: 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .form-group select option {
        background: white;
        color: #1e293b;
        padding: 10px;
    }

    .form-group input::placeholder {
        color: #94a3b8;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #e5e7eb;
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

    .btn-warning {
        background: #f59e0b;
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    .btn-warning:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 2px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .page-container {
            padding: 20px;
        }
    }
</style>

<div class="page-container">
    <div class="form-header">
        <i class='bx bx-edit'></i>
        <h2>Edit Pembelian</h2>
    </div>

    <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="id_pembelian">ID Pembelian <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="id_pembelian" 
                    name="id_pembelian" 
                    value="{{ old('id_pembelian', $pembelian->id_pembelian) }}"
                    placeholder="Contoh: LK08082"
                    required
                >
                @error('id_pembelian')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_supplier">Nama Supplier <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="nama_supplier" 
                    name="nama_supplier" 
                    value="{{ old('nama_supplier', $pembelian->nama_supplier) }}"
                    placeholder="Contoh: Toko Karet"
                    required
                >
                @error('nama_supplier')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nama_barang">Nama Barang <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="nama_barang" 
                    name="nama_barang" 
                    value="{{ old('nama_barang', $pembelian->nama_barang) }}"
                    placeholder="Contoh: Karet Shock"
                    required
                >
                @error('nama_barang')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="total_pembelian">Total Pembelian <span class="required">*</span></label>
                <input 
                    type="number" 
                    id="total_pembelian" 
                    name="total_pembelian" 
                    value="{{ old('total_pembelian', $pembelian->total_pembelian) }}"
                    placeholder="Contoh: 900000"
                    step="0.01"
                    min="0"
                    required
                >
                @error('total_pembelian')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tanggal_pembelian">Tanggal Pembelian <span class="required">*</span></label>
                <input 
                    type="date" 
                    id="tanggal_pembelian" 
                    name="tanggal_pembelian" 
                    value="{{ old('tanggal_pembelian', $pembelian->tanggal_pembelian->format('Y-m-d')) }}"
                    required
                >
                @error('tanggal_pembelian')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Complete" {{ old('status', $pembelian->status) == 'Complete' ? 'selected' : '' }}>Complete</option>
                    <option value="Pending" {{ old('status', $pembelian->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Cancelled" {{ old('status', $pembelian->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Batal
            </a>
            <button type="submit" class="btn btn-warning">
                <i class='bx bx-save'></i> Update Pembelian
            </button>
        </div>
    </form>
</div>

@endsection