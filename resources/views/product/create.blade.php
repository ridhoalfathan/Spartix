@extends('layouts.main')

@section('page-title', 'Tambah Produk')

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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-header h2 {
        margin: 0;
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: rgba(255,255,255,0.9);
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
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
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        background: rgba(255,255,255,0.15);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
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

    .image-upload {
        position: relative;
    }

    .image-preview {
        width: 100%;
        max-width: 300px;
        height: 300px;
        border: 2px dashed rgba(255,255,255,0.3);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 15px;
        background: rgba(255,255,255,0.05);
        overflow: hidden;
        transition: 0.3s;
    }

    .image-preview:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .image-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: none;
    }

    .image-preview.has-image img {
        display: block;
    }

    .image-preview-placeholder {
        text-align: center;
        color: rgba(255,255,255,0.5);
    }

    .image-preview-placeholder i {
        font-size: 60px;
        margin-bottom: 10px;
        opacity: 0.5;
    }

    .image-preview.has-image .image-preview-placeholder {
        display: none;
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: 500;
    }

    .file-input-label:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
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

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
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
        .form-card {
            padding: 20px;
        }

        .form-header h2 {
            font-size: 20px;
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

<div class="form-card">
    <div class="form-header">
        <i class='bx bx-package'></i>
        <h2>Tambah Produk Baru</h2>
    </div>

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="product_name">Nama Produk <span style="color: #ff6b6b;">*</span></label>
            <input 
                type="text" 
                id="product_name" 
                name="product_name" 
                value="{{ old('product_name') }}"
                placeholder="Contoh: Karet shock kecil"
                required
            >
            @error('product_name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stock <span style="color: #ff6b6b;">*</span></label>
            <input 
                type="number" 
                id="stock" 
                name="stock" 
                value="{{ old('stock', 0) }}"
                placeholder="Contoh: 500"
                min="0"
                required
            >
            @error('stock')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group image-upload">
            <label>Gambar Produk (Opsional)</label>
            <div class="file-input-wrapper">
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/*"
                    onchange="previewImage(event)"
                >
                <label for="image" class="file-input-label">
                    <i class='bx bx-upload'></i>
                    <span>Pilih Gambar</span>
                </label>
            </div>
            @error('image')
                <span class="error-message">{{ $message }}</span>
            @enderror

            <div class="image-preview" id="imagePreview">
                <div class="image-preview-placeholder">
                    <i class='bx bx-image'></i>
                    <p>Preview gambar akan muncul di sini</p>
                </div>
                <img id="previewImg" src="" alt="Preview">
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('product.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-check'></i> Simpan Produk
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.add('has-image');
        }
        reader.readAsDataURL(file);
    }
}
</script>

@endsection