@extends('layouts.main')

@section('page-title', 'Buat Pesanan')

@section('content')
<style>
    .form-card {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        max-width: 800px;
        margin: 0 auto;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(30, 58, 138, 0.1);
    }

    .form-header i {
        font-size: 32px;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
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

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        margin-bottom: 8px;
        font-weight: 500;
        color: #1e3a8a;
        font-size: 14px;
    }

    .form-group input,
    .form-group select {
        padding: 12px 15px;
        border: 2px solid rgba(30, 58, 138, 0.2);
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
        border-color: #2563eb;
        background: rgba(37, 99, 235, 0.02);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-group select option {
        background: white;
        color: #1e293b;
        padding: 10px;
    }

    .form-group input::placeholder {
        color: #94a3b8;
    }

    .form-group input[readonly] {
        background: rgba(30, 58, 138, 0.05);
        color: #1e3a8a;
        font-weight: 600;
        cursor: not-allowed;
    }

    .radio-group {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 8px 16px;
        border: 2px solid rgba(30, 58, 138, 0.2);
        border-radius: 8px;
        transition: all 0.3s;
    }

    .radio-option:hover {
        border-color: #2563eb;
        background: rgba(37, 99, 235, 0.02);
    }

    .radio-option input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    .radio-option label {
        margin: 0;
        cursor: pointer;
        font-size: 14px;
        color: #334155;
        font-weight: 500;
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
        border-top: 2px solid rgba(30, 58, 138, 0.1);
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
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #1e3a8a;
        border: 2px solid rgba(30, 58, 138, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(30, 58, 138, 0.05);
        border-color: #1e3a8a;
    }

    .required {
        color: #ef4444;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-card {
            padding: 20px;
        }

        .radio-group {
            flex-direction: column;
        }
    }
</style>

<div class="form-card">
    <div class="form-header">
        <i class='bx bx-receipt'></i>
        <h2>Buat Pesanan Baru</h2>
    </div>

    <form action="{{ route('pesanan.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="id_pesanan">ID Pesanan</label>
                <input 
                    type="text" 
                    id="id_pesanan" 
                    value="{{ App\Models\Pesanan::generateIdPesanan() }}" 
                    readonly
                >
            </div>

            <div class="form-group">
                <label for="tanggal_pembayaran">Tanggal Pembayaran <span class="required">*</span></label>
                <input 
                    type="date" 
                    id="tanggal_pembayaran" 
                    name="tanggal_pembayaran" 
                    value="{{ old('tanggal_pembayaran', date('Y-m-d')) }}"
                    required
                >
                @error('tanggal_pembayaran')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label for="nama_pemesan">Nama Pemesan <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="nama_pemesan" 
                    name="nama_pemesan" 
                    value="{{ old('nama_pemesan') }}"
                    placeholder="Masukkan nama pemesan"
                    required
                >
                @error('nama_pemesan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="product_id">Nama Produk <span class="required">*</span></label>
                <select id="product_id" name="product_id" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->product_name }} (Stock: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jumlah_pesanan">Jumlah Pesanan <span class="required">*</span></label>
                <input 
                    type="number" 
                    id="jumlah_pesanan" 
                    name="jumlah_pesanan" 
                    value="{{ old('jumlah_pesanan') }}"
                    placeholder="Contoh: 120"
                    min="1"
                    required
                >
                @error('jumlah_pesanan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label>Status <span class="required">*</span></label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input 
                            type="radio" 
                            id="pending" 
                            name="status" 
                            value="Pending" 
                            {{ old('status', 'Pending') == 'Pending' ? 'checked' : '' }}
                        >
                        <label for="pending">Pending</label>
                    </div>
                    <div class="radio-option">
                        <input 
                            type="radio" 
                            id="complete" 
                            name="status" 
                            value="Complete"
                            {{ old('status') == 'Complete' ? 'checked' : '' }}
                        >
                        <label for="complete">Complete</label>
                    </div>
                </div>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <p style="font-size: 12px; color: #64748b; margin-top: 8px;">
                    <i class='bx bx-info-circle'></i> Status "Complete" akan mengurangi stock produk secara otomatis
                </p>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-check'></i> Simpan Pesanan
            </button>
        </div>
    </form>
</div>

@endsection