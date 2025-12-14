@extends('layouts.main')

@section('page-title', 'Edit Produksi')

@section('content')

<style>
    .container-form {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(30, 58, 138, 0.1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        max-width: 800px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .page-header h2 {
        margin: 0 0 10px 0;
        font-size: 32px;
        font-weight: 700;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
    }

    .form-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #1e3a8a;
        font-size: 14px;
    }

    .form-group label .required {
        color: #ef4444;
        margin-left: 4px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid rgba(30, 58, 138, 0.1);
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        transition: all 0.3s;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        display: block;
    }

    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%231e3a8a' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
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
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 30px;
        justify-content: flex-end;
    }

    .alert {
        padding: 16px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #dc2626;
    }

    .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #d97706;
    }

    .alert i {
        font-size: 20px;
    }

    .form-hint {
        font-size: 12px;
        color: #64748b;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-hint i {
        font-size: 14px;
    }

    .info-box {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .info-box h4 {
        margin: 0 0 10px 0;
        color: #1e3a8a;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-box p {
        margin: 0;
        font-size: 13px;
        color: #334155;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-form {
            padding: 20px;
        }

        .form-card {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-form">
    <div class="page-header">
        <h2>Edit Data Produksi</h2>
        <p>Perbarui informasi produksi di bawah ini</p>
    </div>

    <div class="form-card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class='bx bx-error-circle'></i>
                <div>
                    <strong>Terdapat kesalahan:</strong>
                    <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if($produksi->status === 'Selesai')
            <div class="alert alert-warning">
                <i class='bx bx-info-circle'></i>
                <div>
                    <strong>Perhatian:</strong> Produksi ini berstatus "Selesai". 
                    Perubahan status atau quantity akan mempengaruhi stok produk!
                </div>
            </div>
        @endif

        <div class="info-box">
            <h4>
                <i class='bx bx-info-circle'></i>
                Informasi Produksi Saat Ini
            </h4>
            <p><strong>Produk:</strong> {{ $produksi->product->product_name }}</p>
            <p><strong>Status:</strong> {{ $produksi->status }}</p>
            <p><strong>Quantity:</strong> {{ number_format($produksi->quantity) }} unit</p>
            <p><strong>Stok Produk Saat Ini:</strong> {{ number_format($produksi->product->stock) }} unit</p>
        </div>

        <form action="{{ route('produksi.update', $produksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="product_id">
                    Pilih Produk <span class="required">*</span>
                </label>
                <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" 
                                {{ (old('product_id', $produksi->product_id) == $product->id) ? 'selected' : '' }}>
                            {{ $product->product_name }} (Stok: {{ number_format($product->stock) }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="karyawan_id">
                    Nama Karyawan <span class="required">*</span>
                </label>
                <select name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}" 
                                {{ (old('karyawan_id', $produksi->karyawan_id) == $karyawan->id) ? 'selected' : '' }}>
                            {{ $karyawan->nama_karyawan }} - {{ $karyawan->jabatan }}
                        </option>
                    @endforeach
                </select>
                @error('karyawan_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tanggal">
                        Tanggal Produksi <span class="required">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal" 
                           id="tanggal" 
                           class="form-control @error('tanggal') is-invalid @enderror" 
                           value="{{ old('tanggal', $produksi->tanggal->format('Y-m-d')) }}"
                           required>
                    @error('tanggal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="waktu">
                        Waktu Produksi <span class="required">*</span>
                    </label>
                    <input type="time" 
                           name="waktu" 
                           id="waktu" 
                           class="form-control @error('waktu') is-invalid @enderror" 
                           value="{{ old('waktu', $produksi->waktu) }}"
                           required>
                    @error('waktu')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="quantity">
                    Jumlah Produksi (Quantity) <span class="required">*</span>
                </label>
                <input type="number" 
                       name="quantity" 
                       id="quantity" 
                       class="form-control @error('quantity') is-invalid @enderror" 
                       value="{{ old('quantity', $produksi->quantity) }}"
                       placeholder="Contoh: 100"
                       min="1"
                       required>
                @error('quantity')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <div class="form-hint">
                    <i class='bx bx-info-circle'></i>
                    Quantity awal: {{ number_format($produksi->quantity) }} unit
                </div>
            </div>

            <div class="form-group">
                <label for="status">
                    Status Produksi <span class="required">*</span>
                </label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Belum Diproses" {{ old('status', $produksi->status) == 'Belum Diproses' ? 'selected' : '' }}>Belum Diproses</option>
                    <option value="Proses" {{ old('status', $produksi->status) == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Sedang Diproses" {{ old('status', $produksi->status) == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="Menunggu Bahan" {{ old('status', $produksi->status) == 'Menunggu Bahan' ? 'selected' : '' }}>Menunggu Bahan</option>
                    <option value="Selesai" {{ old('status', $produksi->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ old('status', $produksi->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <div class="form-hint">
                    <i class='bx bx-info-circle'></i>
                    <strong>Penting:</strong> Perubahan status akan mempengaruhi stok produk otomatis!
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">
                    Keterangan (Opsional)
                </label>
                <textarea name="keterangan" 
                          id="keterangan" 
                          class="form-control @error('keterangan') is-invalid @enderror"
                          placeholder="Tambahkan keterangan jika diperlukan...">{{ old('keterangan', $produksi->keterangan) }}</textarea>
                @error('keterangan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('produksi.index') }}" class="btn btn-secondary">
                    <i class='bx bx-x'></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-save'></i> Update Produksi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const originalStatus = '{{ $produksi->status }}';
    const originalQuantity = {{ $produksi->quantity }};

    document.querySelector('form').addEventListener('submit', function(e) {
        const newStatus = document.getElementById('status').value;
        const newQuantity = parseInt(document.getElementById('quantity').value);
        const productSelect = document.getElementById('product_id');
        const productName = productSelect.options[productSelect.selectedIndex].text;
        
        let message = '';
        
        // Check status change
        if (originalStatus !== 'Selesai' && newStatus === 'Selesai') {
            message = `Status berubah menjadi "Selesai".\nStok ${productName} akan bertambah ${newQuantity} unit.\n\nLanjutkan?`;
        } else if (originalStatus === 'Selesai' && newStatus !== 'Selesai') {
            message = `Status berubah dari "Selesai".\nStok ${productName} akan berkurang ${originalQuantity} unit.\n\nLanjutkan?`;
        } else if (originalStatus === 'Selesai' && newStatus === 'Selesai' && originalQuantity !== newQuantity) {
            const diff = newQuantity - originalQuantity;
            if (diff > 0) {
                message = `Quantity bertambah ${diff} unit.\nStok ${productName} akan bertambah ${diff} unit.\n\nLanjutkan?`;
            } else {
                message = `Quantity berkurang ${Math.abs(diff)} unit.\nStok ${productName} akan berkurang ${Math.abs(diff)} unit.\n\nLanjutkan?`;
            }
        }
        
        if (message && !confirm(message)) {
            e.preventDefault();
        }
    });
</script>

@endsection