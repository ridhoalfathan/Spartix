@extends('layouts.main')

@section('title', 'Tambah Barang Masuk - RAYA-E')

@section('styles')
<style>
    .page-header {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }
    
    .page-title i {
        color: #22c55e;
    }
    
    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0.5rem 0 0 0;
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
        font-weight: 600;
    }
    
    .breadcrumb-item.active {
        color: #64748b;
    }
    
    .form-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.95rem;
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
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        outline: none;
    }
    
    .form-text {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 0.5rem;
        display: block;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
    }
    
    .serial-preview {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #22c55e;
        margin-top: 1rem;
    }
    
    .preview-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #166534;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .preview-info {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 0.75rem;
    }
    
    .preview-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    
    .preview-value {
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
        font-weight: 700;
        color: #166534;
    }
    
    .serial-examples {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }
    
    .serial-example {
        background: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #166534;
        font-size: 0.85rem;
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
        text-decoration: none;
        cursor: pointer;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(34, 197, 94, 0.4);
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
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        border: none;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }
    
    .alert-danger ul {
        margin: 0.5rem 0 0 1.25rem;
        padding: 0;
    }
    
    .info-box {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        border-left: 4px solid #2563EB;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }
    
    .info-box i {
        font-size: 1.25rem;
        margin-top: 0.125rem;
    }
    
    .input-group {
        position: relative;
    }
    
    .currency-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-weight: 600;
        pointer-events: none;
        z-index: 1;
    }
    
    .form-control.with-currency {
        padding-left: 2.5rem;
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
        <i class="bi bi-box-arrow-in-down-fill"></i>
        Tambah Barang Masuk
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('barang-masuk.index') }}">Barang Masuk</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<!-- Form Card -->
<div class="form-card">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-triangle"></i> Oops!</strong> Ada beberapa masalah dengan input Anda:
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('barang-masuk.store') }}" method="POST" id="formBarangMasuk">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Barang <span class="required">*</span>
                    </label>
                    <select name="barang_id" id="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barang as $item)
                        <option value="{{ $item->id }}" 
                                data-kategori="{{ $item->kategori }}"
                                {{ old('barang_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->kode_barang }} - {{ $item->nama_barang }} ({{ $item->kategori }})
                        </option>
                        @endforeach
                    </select>
                    @error('barang_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Jumlah <span class="required">*</span>
                    </label>
                    <input type="number" 
                           name="jumlah" 
                           id="jumlah" 
                           class="form-control @error('jumlah') is-invalid @enderror" 
                           placeholder="Masukkan jumlah" 
                           value="{{ old('jumlah', 1) }}" 
                           min="1" 
                           required>
                    <small class="form-text">Serial number akan di-generate otomatis sejumlah ini</small>
                    @error('jumlah')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Harga Beli (per unit) <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <span class="currency-icon">Rp</span>
                        <input type="text" 
                               name="harga_beli_display" 
                               id="harga-input"
                               class="form-control with-currency @error('harga_beli') is-invalid @enderror" 
                               placeholder="0"
                               value="{{ old('harga_beli') ? number_format(old('harga_beli'), 0, ',', '.') : '' }}" 
                               required>
                        <input type="hidden" name="harga_beli" id="harga-hidden" value="{{ old('harga_beli', 0) }}">
                    </div>
                    @error('harga_beli')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Tanggal Masuk <span class="required">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal_masuk" 
                           id="tanggal_masuk"
                           class="form-control @error('tanggal_masuk') is-invalid @enderror" 
                           value="{{ old('tanggal_masuk', date('Y-m-d')) }}" 
                           min="{{ date('Y-m-d') }}"
                           required>
                    @error('tanggal_masuk')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Supplier</label>
                    <input type="text" 
                           name="supplier" 
                           class="form-control @error('supplier') is-invalid @enderror" 
                           placeholder="Nama supplier (opsional)" 
                           value="{{ old('supplier') }}">
                    @error('supplier')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Serial Number Preview -->
        <div class="serial-preview" id="serialPreview" style="display: none;">
            <div class="preview-title">
                <i class="bi bi-upc-scan"></i>
                Preview Serial Number
            </div>
            
            <div class="preview-info">
                <div class="preview-label">Format Serial Number</div>
                <div class="preview-value" id="formatPreview">-</div>
            </div>
            
            <div class="preview-info">
                <div class="preview-label">Serial Number yang akan di-generate:</div>
                <div class="serial-examples" id="examplesContainer">
                    <!-- Will be filled by JavaScript -->
                </div>
            </div>
            
        </div>
        
        <div class="info-box">
            <i class="bi bi-info-circle"></i>
            <div>
                <strong>Info:</strong> Serial number akan di-generate otomatis dengan format: 
                <code style="background: rgba(37, 99, 235, 0.1); padding: 0.25rem 0.5rem; border-radius: 4px; font-weight: 700;">{KATEGORI}{YYMMDD}-{URUT}</code>
            </div>
        </div>
        
        <div class="btn-group">
            <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i>
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i>
                Simpan Transaksi
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const barangSelect = document.getElementById('barang_id');
    const jumlahInput = document.getElementById('jumlah');
    const tanggalInput = document.getElementById('tanggal_masuk');
    const serialPreview = document.getElementById('serialPreview');
    const formatPreview = document.getElementById('formatPreview');
    const examplesContainer = document.getElementById('examplesContainer');
    const form = document.getElementById('formBarangMasuk');
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    tanggalInput.setAttribute('min', today);
    
    // Validate date on change
    tanggalInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const currentDate = new Date(today);
        
        if (selectedDate < currentDate) {
            alert('Tanggal masuk tidak boleh sebelum hari ini!');
            this.value = today;
        }
    });
    
    // Validate on form submit
    form.addEventListener('submit', function(e) {
        const selectedDate = new Date(tanggalInput.value);
        const currentDate = new Date(today);
        
        if (selectedDate < currentDate) {
            e.preventDefault();
            alert('Tanggal masuk tidak boleh sebelum hari ini!');
            tanggalInput.focus();
            return false;
        }
    });
    
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
    
    // Update preview when any input changes
    function updatePreview() {
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        const kategori = selectedOption.getAttribute('data-kategori');
        const jumlah = parseInt(jumlahInput.value) || 0;
        const tanggal = new Date(tanggalInput.value);
        
        if (!kategori || !jumlah || isNaN(tanggal.getTime())) {
            serialPreview.style.display = 'none';
            return;
        }
        
        // Show preview
        serialPreview.style.display = 'block';
        
        // Generate format
        const prefix = kategori.substring(0, 3).toUpperCase();
        const yy = tanggal.getFullYear().toString().slice(-2);
        const mm = String(tanggal.getMonth() + 1).padStart(2, '0');
        const dd = String(tanggal.getDate()).padStart(2, '0');
        const dateCode = yy + mm + dd;
        
        const format = `${prefix}${dateCode}-XXXX`;
        formatPreview.textContent = format;
        
        // Generate examples
        examplesContainer.innerHTML = '';
        const maxExamples = Math.min(jumlah, 5);
        
        for (let i = 1; i <= maxExamples; i++) {
            const exampleSerial = `${prefix}${dateCode}-${String(i).padStart(4, '0')}`;
            const span = document.createElement('span');
            span.className = 'serial-example';
            span.textContent = exampleSerial;
            examplesContainer.appendChild(span);
        }
        
        if (jumlah > 5) {
            const moreSpan = document.createElement('span');
            moreSpan.className = 'serial-example';
            moreSpan.style.background = 'transparent';
            moreSpan.style.color = '#64748b';
            moreSpan.textContent = `... dan ${jumlah - 5} lainnya`;
            examplesContainer.appendChild(moreSpan);
        }
    }
    
    // Add event listeners
    barangSelect.addEventListener('change', updatePreview);
    jumlahInput.addEventListener('input', updatePreview);
    tanggalInput.addEventListener('change', updatePreview);
    
    // Initial update if values exist
    if (barangSelect.value && jumlahInput.value && tanggalInput.value) {
        updatePreview();
    }
});
</script>
@endsection