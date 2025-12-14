@extends('layouts.main')

@section('page-title', 'Edit Produk')

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

    .stock-info-box {
        background: linear-gradient(135deg, rgba(30, 58, 138, 0.05), rgba(37, 99, 235, 0.05));
        border: 1px solid rgba(30, 58, 138, 0.2);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .stock-info-box h4 {
        margin: 0 0 12px 0;
        font-size: 14px;
        font-weight: 600;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stock-info-box h4 i {
        font-size: 18px;
    }

    .stock-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
    }

    .stock-item {
        background: white;
        padding: 12px 16px;
        border-radius: 8px;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .stock-item label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 4px;
    }

    .stock-item .value {
        font-size: 20px;
        font-weight: 700;
        color: #1e3a8a;
    }

    .info-box {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
        display: flex;
        align-items: start;
        gap: 12px;
    }

    .info-box i {
        font-size: 20px;
        color: #2563eb;
        margin-top: 2px;
    }

    .info-box p {
        margin: 0;
        font-size: 13px;
        color: #334155;
        line-height: 1.6;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr;
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
        color: #1e3a8a;
        font-size: 14px;
    }

    .form-group input {
        padding: 12px 15px;
        border: 2px solid rgba(30, 58, 138, 0.2);
        border-radius: 8px;
        background: white;
        color: #1e293b;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        transition: 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #2563eb;
        background: rgba(37, 99, 235, 0.02);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-group input::placeholder {
        color: #94a3b8;
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

    .current-image {
        margin-top: 10px;
        text-align: center;
    }

    .current-image img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 12px;
        border: 2px solid rgba(30, 58, 138, 0.2);
        object-fit: cover;
        margin-bottom: 10px;
    }

    .current-image p {
        margin: 0;
        font-size: 12px;
        color: #64748b;
    }

    .image-upload-area {
        border: 2px dashed rgba(30, 58, 138, 0.3);
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        background: rgba(30, 58, 138, 0.02);
        cursor: pointer;
        transition: all 0.3s;
    }

    .image-upload-area:hover {
        border-color: #2563eb;
        background: rgba(37, 99, 235, 0.05);
    }

    .image-upload-area i {
        font-size: 48px;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .image-upload-area p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .image-upload-area small {
        color: #94a3b8;
        font-size: 12px;
    }

    .image-preview-container {
        margin-top: 15px;
        display: none;
        position: relative;
    }

    .image-preview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 12px;
        border: 2px solid rgba(30, 58, 138, 0.2);
        object-fit: cover;
    }

    .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s;
    }

    .remove-image:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .error-message i {
        font-size: 14px;
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
        .form-card {
            padding: 20px;
        }

        .stock-details {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-card">
    <div class="form-header">
        <i class='bx bx-edit'></i>
        <h2>Edit Produk</h2>
    </div>

    <!-- Stock Information Box -->
    <div class="stock-info-box">
        <h4>
            <i class='bx bx-cube'></i>
            Informasi Stok Saat Ini
        </h4>
        <div class="stock-details">
            <div class="stock-item">
                <label>Stok Tersedia</label>
                <div class="value">{{ number_format($product->stock) }}</div>
            </div>
            <div class="stock-item">
                <label>Total Produksi</label>
                <div class="value">{{ $product->produksis->count() }}</div>
            </div>
            <div class="stock-item">
                <label>Produksi Selesai</label>
                <div class="value">{{ $product->produksis->where('status', 'Selesai')->count() }}</div>
            </div>
        </div>
    </div>

    <div class="info-box">
        <i class='bx bx-info-circle'></i>
        <p>Stok tidak dapat diubah secara manual. Stok akan otomatis berubah dari data produksi yang berstatus "Selesai".</p>
    </div>

    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="product_name">Nama Produk <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="product_name" 
                    name="product_name" 
                    value="{{ old('product_name', $product->product_name) }}"
                    placeholder="Contoh: Karet Kompo Grade A"
                    required
                >
                @error('product_name')
                    <span class="error-message">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price">Harga per Unit <span class="required">*</span></label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    value="{{ old('price', $product->price) }}"
                    placeholder="Contoh: 150000"
                    step="0.01"
                    min="0"
                    required
                >
                @error('price')
                    <span class="error-message">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </span>
                @enderror
                <div class="form-hint">
                    <i class='bx bx-info-circle'></i>
                    Harga dalam Rupiah (tanpa titik atau koma)
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="image">Gambar Produk</label>
                
                @if($product->image)
                    <div class="current-image">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                        <p>Gambar saat ini</p>
                    </div>
                @endif
                
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                    onchange="previewImage(event)"
                    style="display: none;"
                >
                <div class="image-upload-area" onclick="document.getElementById('image').click()">
                    <i class='bx bx-cloud-upload'></i>
                    <p><strong>{{ $product->image ? 'Klik untuk ganti gambar' : 'Klik untuk upload gambar' }}</strong></p>
                    <small>Format: JPG, PNG, GIF (Max 2MB)</small>
                </div>
                @error('image')
                    <span class="error-message">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </span>
                @enderror
                <div class="image-preview-container" id="imagePreviewContainer">
                    <img id="imagePreview" class="image-preview" src="" alt="Preview">
                    <button type="button" class="remove-image" onclick="removeImage()">
                        <i class='bx bx-x'></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('product.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-check'></i> Update Produk
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const container = document.getElementById('imagePreviewContainer');
    
    if (file) {
        // Check file size (2MB)
        if (file.size > 2097152) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    const input = document.getElementById('image');
    const container = document.getElementById('imagePreviewContainer');
    
    input.value = '';
    container.style.display = 'none';
}
</script>

@endsection