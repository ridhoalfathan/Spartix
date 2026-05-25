@extends('layouts.main')

@section('title', 'Tambah Barang - RAYA-E')

@section('styles')
<style>
    .page-header {
        background: #ffffff;
        padding: 1.75rem 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
    }
    
    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
        letter-spacing: -0.5px;
    }
    
    .page-title i {
        color: #2563EB;
        font-size: 2rem;
    }
    
    .breadcrumb {
        background: none;
        padding: 0;
        margin-top: 0.5rem;
        font-size: 0.9rem;
    }
    
    .breadcrumb-item {
        display: inline-block;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        padding: 0 0.5rem;
        color: #cbd5e1;
    }
    
    .breadcrumb-item a {
        color: #2563EB;
        text-decoration: none;
        font-weight: 700;
    }
    
    .breadcrumb-item a:hover {
        text-decoration: underline;
    }
    
    .breadcrumb-item.active {
        color: #64748b;
        font-weight: 600;
    }
    
    .form-card {
        background: #ffffff;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-label .required {
        color: #ef4444;
    }
    
    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
        font-weight: 500;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }
    
    .form-control:hover, .form-select:hover {
        border-color: #cbd5e1;
    }
    
    .form-text {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 0.5rem;
        display: block;
        font-weight: 500;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
        font-weight: 600;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
    }
    
    .btn-group {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f1f5f9;
    }
    
    .btn {
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    }
    
    .btn-secondary {
        background: #94a3b8;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #64748b;
        transform: translateY(-2px);
        color: white;
    }
    
    .alert {
        padding: 1.25rem 1.5rem;
        border-radius: 14px;
        margin-bottom: 2rem;
        border: none;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .alert-danger ul {
        margin: 0.75rem 0 0 1.25rem;
        padding: 0;
    }
    
    .alert-danger li {
        margin: 0.25rem 0;
    }
    
    .kategori-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.15);
        margin-top: 0.25rem;
    }
    
    .kategori-suggestions.show {
        display: block;
    }
    
    .suggestion-item {
        padding: 0.875rem 1.125rem;
        cursor: pointer;
        transition: all 0.2s;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 600;
        color: #1e3a8a;
    }
    
    .suggestion-item:last-child {
        border-bottom: none;
    }
    
    .suggestion-item:hover {
        background: rgba(37, 99, 235, 0.08);
        color: #2563EB;
    }
    
    .input-group {
        position: relative;
    }
    
    .currency-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #2563EB;
        font-weight: 800;
        pointer-events: none;
        z-index: 1;
    }
    
    .form-control.with-currency {
        padding-left: 2.75rem;
    }
    
    .info-box {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.08) 0%, rgba(30, 64, 175, 0.08) 100%);
        color: #1e3a8a;
        border-left: 4px solid #2563EB;
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        display: flex;
        align-items: start;
        gap: 0.875rem;
        font-weight: 600;
    }
    
    .info-box i {
        font-size: 1.5rem;
        margin-top: 0.125rem;
        color: #2563EB;
    }
    
    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem;
        }
        
        .btn-group {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-plus-circle-fill"></i>
        Tambah Barang
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Data Barang</a></li>
            <li class="breadcrumb-item active">Tambah Barang</li>
        </ol>
    </nav>
</div>

<!-- Form Card -->
<div class="form-card">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i> Oops!</strong> Ada beberapa masalah dengan input Anda:
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('barang.store') }}" method="POST" id="form-barang">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Nama Barang <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="nama_barang" 
                           class="form-control @error('nama_barang') is-invalid @enderror" 
                           placeholder="Contoh: Samsung Smart TV 43 Inch" 
                           value="{{ old('nama_barang') }}" 
                           required>
                    @error('nama_barang')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Kategori <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="kategori" 
                           id="kategori-input"
                           class="form-control @error('kategori') is-invalid @enderror" 
                           placeholder="Ketik atau pilih kategori (TV, AC, Kulkas, dll)"
                           value="{{ old('kategori') }}" 
                           required
                           autocomplete="off">
                    <div id="kategori-suggestions" class="kategori-suggestions">
                        @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories as $cat)
                                <div class="suggestion-item" data-value="{{ $cat }}">{{ $cat }}</div>
                            @endforeach
                        @else
                            <div class="suggestion-item" data-value="TV">TV</div>
                            <div class="suggestion-item" data-value="AC">AC</div>
                            <div class="suggestion-item" data-value="Kulkas">Kulkas</div>
                            <div class="suggestion-item" data-value="Mesin Cuci">Mesin Cuci</div>
                            <div class="suggestion-item" data-value="Dispenser">Dispenser</div>
                        @endif
                    </div>
                    <small class="form-text">Ketik kategori baru atau pilih dari daftar</small>
                    @error('kategori')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Merk <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="merk" 
                           class="form-control @error('merk') is-invalid @enderror" 
                           placeholder="Contoh: Samsung, LG, Sharp" 
                           value="{{ old('merk') }}" 
                           required>
                    @error('merk')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Harga Barang <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <span class="currency-icon">Rp</span>
                        <input type="text" 
                               name="harga_display" 
                               id="harga-input"
                               class="form-control with-currency @error('harga') is-invalid @enderror" 
                               placeholder="0"
                               value="{{ old('harga') ? number_format(old('harga'), 0, ',', '.') : '' }}" 
                               required>
                        <input type="hidden" name="harga" id="harga-hidden" value="{{ old('harga', 0) }}">
                    </div>
                    <small class="form-text">Harga jual barang</small>
                    @error('harga')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">
                        Stok Minimum <span class="required">*</span>
                    </label>
                    <input type="number" 
                           name="stok_minimum" 
                           class="form-control @error('stok_minimum') is-invalid @enderror" 
                           placeholder="Contoh: 5" 
                           value="{{ old('stok_minimum', 5) }}" 
                           min="1" 
                           required>
                    <small class="form-text">Batas minimum stok untuk notifikasi peringatan</small>
                    @error('stok_minimum')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="info-box">
            <i class="bi bi-info-circle-fill"></i>
            <div>
                <strong>Info:</strong> Kode barang akan dibuat otomatis oleh sistem berdasarkan kategori. Stok awal adalah 0, Anda dapat menambahkan stok melalui menu "Pembelian Barang".
            </div>
        </div>
        
        <div class="btn-group">
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle-fill"></i>
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save-fill"></i>
                Simpan Barang
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Kategori Autocomplete
    const kategoriInput = document.getElementById('kategori-input');
    const suggestionBox = document.getElementById('kategori-suggestions');
    
    if (kategoriInput && suggestionBox) {
        kategoriInput.addEventListener('focus', function() {
            suggestionBox.classList.add('show');
        });
        
        kategoriInput.addEventListener('input', function() {
            const value = this.value.toLowerCase();
            const items = suggestionBox.querySelectorAll('.suggestion-item');
            let hasMatch = false;
            
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(value)) {
                    item.style.display = 'block';
                    hasMatch = true;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (hasMatch || value === '') {
                suggestionBox.classList.add('show');
            } else {
                suggestionBox.classList.remove('show');
            }
        });
        
        suggestionBox.querySelectorAll('.suggestion-item').forEach(item => {
            item.addEventListener('click', function() {
                kategoriInput.value = this.getAttribute('data-value');
                suggestionBox.classList.remove('show');
            });
        });
        
        document.addEventListener('click', function(e) {
            if (!kategoriInput.contains(e.target) && !suggestionBox.contains(e.target)) {
                suggestionBox.classList.remove('show');
            }
        });
    }
    
    // Format Harga dengan Thousand Separator
    const hargaInput = document.getElementById('harga-input');
    const hargaHidden = document.getElementById('harga-hidden');
    
    if (hargaInput && hargaHidden) {
        hargaInput.addEventListener('input', function(e) {
            let value = this.value.replace(/[^\d]/g, '');
            this.value = formatNumber(value);
            hargaHidden.value = value;
        });
        
        hargaInput.addEventListener('blur', function() {
            if (this.value === '' || this.value === '0') {
                this.value = '0';
                hargaHidden.value = '0';
            }
        });
        
        // Set initial value if exists
        const initialValue = hargaHidden.value;
        if (initialValue && initialValue !== '0') {
            hargaInput.value = formatNumber(initialValue);
        }
    }
    
    // Format number with thousand separator
    function formatNumber(num) {
        return num.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
});
</script>
@endsection