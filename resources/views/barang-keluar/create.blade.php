@extends('layouts.main')

@section('title', 'Tambah Penjualan - RAYA-E')

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
        color: #f59e0b;
    }
    
    .form-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .item-card {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .item-number {
        font-weight: 800;
        color: #1e3a8a;
        font-size: 1.1rem;
    }
    
    .btn-remove-item {
        background: #ef4444;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-remove-item:hover {
        background: #dc2626;
        transform: translateY(-2px);
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
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
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
    
    .btn-add-item {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }
    
    .btn-add-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
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
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
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
    
    .alert-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    
    .total-section {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        padding: 1.5rem;
        border-radius: 12px;
        margin-top: 2rem;
        border-left: 4px solid #2563EB;
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e3a8a;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-box-arrow-up-fill"></i>
        Tambah Penjualan
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: none; padding: 0; margin: 0.5rem 0 0 0;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color: #2563EB; text-decoration: none; font-weight: 600;">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('barang-keluar.index') }}" style="color: #2563EB; text-decoration: none; font-weight: 600;">Barang Keluar</a></li>
            <li class="breadcrumb-item active" style="color: #64748b;">Tambah</li>
        </ol>
    </nav>
</div>

<!-- Form Card -->
<div class="form-card">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Ada beberapa masalah dengan input Anda:
        <ul style="margin: 0.5rem 0 0 1.25rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('barang-keluar.store') }}" method="POST" id="formBarangKeluar">
        @csrf
        
        <!-- Informasi Umum -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Tanggal Keluar <span class="required">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal_keluar" 
                           id="tanggal_keluar" 
                           class="form-control @error('tanggal_keluar') is-invalid @enderror" 
                           value="{{ old('tanggal_keluar', date('Y-m-d')) }}"
                           min="{{ date('Y-m-d') }}"
                           required>
                    <small class="form-text">Hanya dapat memilih tanggal hari ini atau masa depan</small>
                    @error('tanggal_keluar')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Customer</label>
                    <input type="text" name="customer" id="customer" class="form-control @error('customer') is-invalid @enderror" 
                           placeholder="Nama customer (opsional)" value="{{ old('customer') }}">
                    @error('customer')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">
                        Metode Pembayaran <span class="required">*</span>
                    </label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror" required>
                        <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    </select>
                    @error('metode_pembayaran')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <hr style="margin: 2rem 0; border-color: #e2e8f0;">
        
        <!-- Items Section -->
        <div id="items-container">
            <!-- Item pertama akan ditambahkan via JavaScript -->
        </div>
        
        <button type="button" class="btn-add-item" id="addItemBtn">
            <i class="bi bi-plus-circle"></i>
            Tambah Item
        </button>
        
        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <span>Total Penjualan:</span>
                <span id="grandTotal">Rp 0</span>
            </div>
        </div>
        
        <div class="btn-group">
            <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i>
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i>
                Simpan Penjualan
            </button>
        </div>
    </form>
</div>

<script>
let itemCount = 0;
const barangData = @json($barang);

// Template untuk item baru
function getItemTemplate(index) {
    return `
        <div class="item-card" data-item-index="${index}">
            <div class="item-header">
                <span class="item-number">Item #${index + 1}</span>
                ${index > 0 ? `<button type="button" class="btn-remove-item" onclick="removeItem(${index})"><i class="bi bi-trash"></i> Hapus</button>` : ''}
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            Barang <span class="required">*</span>
                        </label>
                        <select name="items[${index}][barang_id]" class="form-select barang-select" data-index="${index}" required>
                            <option value="">-- Pilih Barang --</option>
                            ${barangData.map(item => `
                                <option value="${item.id}" data-stok="${item.stok}" data-harga="${item.harga}">
                                    ${item.kode_barang} - ${item.nama_barang} (Stok: ${item.stok})
                                </option>
                            `).join('')}
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            Jumlah <span class="required">*</span>
                        </label>
                        <input type="number" name="items[${index}][qty]" class="form-control qty-input" 
                               data-index="${index}" value="1" min="1" required disabled>
                        <small style="display: block; color: #64748b; margin-top: 0.5rem;">
                            <span class="stok-info" data-index="${index}">Pilih barang dulu</span>
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            Harga Jual <span class="required">*</span>
                        </label>
                        <input type="number" name="items[${index}][harga_jual]" class="form-control harga-jual" 
                               data-index="${index}" placeholder="Pilih barang untuk isi otomatis" min="0" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Subtotal</label>
                        <input type="text" class="form-control subtotal-display" data-index="${index}" 
                               placeholder="Rp 0" readonly>
                    </div>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group mb-0">
                        <label class="form-label" style="font-size: 0.85rem;">Serial Number yang akan keluar (Otomatis FIFO)</label>
                        <div class="serial-numbers-display p-2 border rounded" data-index="${index}" style="background-color: #f8fafc; font-family: monospace; font-size: 0.9rem; color: #64748b; min-height: 40px; display: flex; align-items: center; flex-wrap: wrap; gap: 4px;">
                            Pilih barang dan jumlah untuk melihat Serial Number
                        </div>
                        <small class="form-text mt-1 sn-warning" data-index="${index}" style="color: #ef4444; display: none;">
                            <i class="bi bi-exclamation-triangle"></i> Harga jual otomatis disesuaikan agar tidak kurang dari HPP tertinggi.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Tambah item pertama saat halaman load
document.addEventListener('DOMContentLoaded', function() {
    addItem();
    
    // Validasi tanggal keluar
    const tanggalInput = document.getElementById('tanggal_keluar');
    const form = document.getElementById('formBarangKeluar');
    const today = new Date().toISOString().split('T')[0];
    
    // Set minimum date to today
    tanggalInput.setAttribute('min', today);
    
    // Validate date on change
    tanggalInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const currentDate = new Date(today);
        
        if (selectedDate < currentDate) {
            alert('Tanggal keluar tidak boleh sebelum hari ini!');
            this.value = today;
        }
    });
    
    // Validate on form submit
    form.addEventListener('submit', function(e) {
        const selectedDate = new Date(tanggalInput.value);
        const currentDate = new Date(today);
        
        if (selectedDate < currentDate) {
            e.preventDefault();
            alert('Tanggal keluar tidak boleh sebelum hari ini!');
            tanggalInput.focus();
            return false;
        }
    });
});

// Fungsi tambah item
document.getElementById('addItemBtn').addEventListener('click', function() {
    addItem();
});

function addItem() {
    const container = document.getElementById('items-container');
    const newItem = document.createElement('div');
    newItem.innerHTML = getItemTemplate(itemCount);
    container.appendChild(newItem.firstElementChild);
    
    // Attach event listeners
    attachItemEvents(itemCount);
    itemCount++;
}

function removeItem(index) {
    const item = document.querySelector(`[data-item-index="${index}"]`);
    if (item) {
        item.remove();
        updateGrandTotal();
        updateItemNumbers();
    }
}

function updateItemNumbers() {
    const items = document.querySelectorAll('.item-card');
    items.forEach((item, idx) => {
        item.querySelector('.item-number').textContent = `Item #${idx + 1}`;
    });
}

function attachItemEvents(index) {
    // Event untuk barang select
    const barangSelect = document.querySelector(`.barang-select[data-index="${index}"]`);
    const qtyInput = document.querySelector(`.qty-input[data-index="${index}"]`);
    const stokInfo = document.querySelector(`.stok-info[data-index="${index}"]`);
    const hargaInput = document.querySelector(`.harga-jual[data-index="${index}"]`);
    const snDisplay = document.querySelector(`.serial-numbers-display[data-index="${index}"]`);
    const snWarning = document.querySelector(`.sn-warning[data-index="${index}"]`);
    
    let serialNumbersData = [];
    
    function updateSNDisplay() {
        const qty = parseInt(qtyInput.value) || 0;
        
        if (serialNumbersData.length === 0) {
            snDisplay.textContent = 'Memuat Serial Number...';
            return;
        }
        
        const selectedSNs = serialNumbersData.slice(0, qty);
        if (selectedSNs.length === 0) {
             snDisplay.textContent = 'Tidak ada Serial Number';
             return;
        }
        
        const snList = selectedSNs.map(sn => `<span class="badge bg-primary" style="font-size: 0.85rem; margin-right: 4px;">${sn.serial_number}</span>`).join('');
        snDisplay.innerHTML = snList;
        
        // Find highest HPP
        const maxHpp = Math.max(...selectedSNs.map(sn => parseFloat(sn.harga_beli)));
        hargaInput.setAttribute('min', maxHpp);
        
        // Check current harga_jual
        const currentHarga = parseFloat(hargaInput.value) || 0;
        if (currentHarga < maxHpp) {
             hargaInput.value = maxHpp;
             snWarning.style.display = 'block';
             setTimeout(() => { snWarning.style.display = 'none'; }, 5000);
        }
        
        updateGrandTotal();
    }
    
    barangSelect.addEventListener('change', function() {
        const barangId = this.value;
        const selectedOption = this.options[this.selectedIndex];
        
        if (!barangId) {
            qtyInput.disabled = true;
            qtyInput.value = '1';
            stokInfo.textContent = 'Pilih barang dulu';
            hargaInput.value = '';
            hargaInput.setAttribute('readonly', true);
            snDisplay.textContent = 'Pilih barang dan jumlah untuk melihat Serial Number';
            serialNumbersData = [];
            updateGrandTotal();
            return;
        }
        
        // Get harga dan stok
        const harga = selectedOption.dataset.harga;
        const stok = parseInt(selectedOption.dataset.stok) || 0;
        
        // Update qty
        qtyInput.disabled = false;
        qtyInput.setAttribute('max', stok);
        if (parseInt(qtyInput.value) > stok) {
            qtyInput.value = stok > 0 ? stok : 1;
        }
        stokInfo.textContent = `Stok tersedia: ${stok}`;
        
        // Set harga jual otomatis
        if (harga && harga > 0) {
            hargaInput.value = harga;
            hargaInput.removeAttribute('readonly');
        } else {
            hargaInput.value = '';
            hargaInput.removeAttribute('readonly');
        }
        
        snDisplay.textContent = 'Memuat Serial Number...';
        fetch(`/get-serial-numbers?barang_id=${barangId}`)
            .then(res => res.json())
            .then(data => {
                serialNumbersData = data;
                updateSNDisplay();
            });
    });
    
    // Event untuk qty
    qtyInput.addEventListener('input', function() {
        const max = parseInt(this.getAttribute('max')) || 0;
        let val = parseInt(this.value);
        if (val > max) {
            this.value = max;
        } else if (val < 1) {
            this.value = 1;
        }
        updateSNDisplay();
    });
    
    // Event untuk harga jual
    hargaInput.addEventListener('input', function() {
        updateGrandTotal();
    });
}

function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.item-card').forEach(card => {
        const index = card.dataset.itemIndex;
        const qtyInput = document.querySelector(`.qty-input[data-index="${index}"]`);
        const hargaInput = document.querySelector(`.harga-jual[data-index="${index}"]`);
        const subtotalDisplay = document.querySelector(`.subtotal-display[data-index="${index}"]`);
        
        const qty = parseFloat(qtyInput ? qtyInput.value : 1) || 0;
        const harga = parseFloat(hargaInput ? hargaInput.value : 0) || 0;
        const subtotal = qty * harga;
        
        if (subtotalDisplay) {
            subtotalDisplay.value = `Rp ${formatNumber(subtotal)}`;
        }
        
        total += subtotal;
    });
    
    const grandTotalEl = document.getElementById('grandTotal');
    if (grandTotalEl) {
        grandTotalEl.textContent = `Rp ${formatNumber(total)}`;
    }
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

// Cleanup unused serial select logic
</script>
@endsection