@extends('layouts.main')

@section('page-title', 'Edit Transaksi')

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

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .info-box {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-box i {
        color: #2563eb;
        font-size: 20px;
    }

    .info-box-content {
        flex: 1;
    }

    .info-box-content strong {
        color: #1e3a8a;
        display: block;
        margin-bottom: 5px;
    }

    .info-box-content p {
        margin: 0;
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
    }

    .info-box-content ul {
        margin: 5px 0 0 20px;
        padding: 0;
    }

    .warning-box {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.3);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .warning-box strong {
        color: #d97706;
        display: block;
        margin-bottom: 5px;
    }

    .warning-box p {
        margin: 0;
        font-size: 13px;
        color: #92400e;
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

    .form-group input[readonly] {
        background: rgba(30, 58, 138, 0.05);
        color: #1e3a8a;
        font-weight: 600;
        cursor: not-allowed;
    }

    .radio-group {
        display: flex;
        gap: 15px;
        margin-top: 10px;
        flex-wrap: wrap;
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
    }
</style>

<div class="form-card">
    <div class="form-header">
        <i class='bx bx-edit'></i>
        <h2>Edit Transaksi</h2>
    </div>

    @if(session('error'))
        <div class="alert alert-error">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="info-box">
        <i class='bx bx-info-circle'></i>
        <div class="info-box-content">
            <strong>Informasi Penting:</strong>
            <p>Perubahan status transaksi akan mempengaruhi:</p>
            <ul>
                <li><strong>Pending/Failed → Success:</strong> Pesanan menjadi Complete & stok berkurang</li>
                <li><strong>Success → Pending/Failed:</strong> Pesanan kembali Pending & stok dikembalikan</li>
            </ul>
        </div>
    </div>

    @if($transaksi->status === 'Success')
        <div class="warning-box">
            <strong>Peringatan!</strong>
            <p>Transaksi ini berstatus Success. Mengubah status akan mengembalikan pesanan ke Pending dan mengembalikan stok produk.</p>
        </div>
    @endif

    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" id="transaksiForm">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="id_transaksi">ID Transaksi</label>
                <input 
                    type="text" 
                    id="id_transaksi" 
                    value="{{ $transaksi->id_transaksi }}" 
                    readonly
                >
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal <span class="required">*</span></label>
                <input 
                    type="date" 
                    id="tanggal" 
                    name="tanggal" 
                    value="{{ old('tanggal', $transaksi->tanggal->format('Y-m-d')) }}"
                    required
                >
                @error('tanggal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label for="pesanan_id">Barang yang Dipesan <span class="required">*</span></label>
                <select id="pesanan_id" name="pesanan_id" required onchange="updateTotal()">
                    <option value="">-- Pilih Pesanan --</option>
                    @foreach($pesanans as $pesanan)
                        <option value="{{ $pesanan->id }}" 
                                data-product="{{ $pesanan->product->product_name }}"
                                data-price="{{ $pesanan->product->price }}"
                                data-qty="{{ $pesanan->jumlah_pesanan }}"
                                data-stock="{{ $pesanan->product->stock }}"
                                data-total="{{ $pesanan->product->price * $pesanan->jumlah_pesanan }}"
                                {{ old('pesanan_id', $transaksi->pesanan_id) == $pesanan->id ? 'selected' : '' }}>
                            {{ $pesanan->id_pesanan }} - {{ $pesanan->product->product_name }} ({{ $pesanan->jumlah_pesanan }} pcs) - Stok: {{ $pesanan->product->stock }}
                        </option>
                    @endforeach
                </select>
                @error('pesanan_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nama_pengirim">Nama Pengirim <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="nama_pengirim" 
                    name="nama_pengirim" 
                    value="{{ old('nama_pengirim', $transaksi->nama_pengirim) }}"
                    placeholder="Masukkan nama pengirim"
                    required
                >
                @error('nama_pengirim')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="total_transaksi">Total Transaksi <span class="required">*</span></label>
                <input 
                    type="number" 
                    id="total_transaksi" 
                    name="total_transaksi" 
                    value="{{ old('total_transaksi', $transaksi->total_transaksi) }}"
                    placeholder="Auto calculated"
                    step="0.01"
                    min="0"
                    readonly
                    required
                >
                @error('total_transaksi')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nama_bank">Nama Bank <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="nama_bank" 
                    name="nama_bank" 
                    value="{{ old('nama_bank', $transaksi->nama_bank) }}"
                    placeholder="Contoh: BCA, Mandiri, BNI"
                    required
                >
                @error('nama_bank')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nomor_rekening">Nomor Rekening <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="nomor_rekening" 
                    name="nomor_rekening" 
                    value="{{ old('nomor_rekening', $transaksi->nomor_rekening) }}"
                    placeholder="Contoh: 1234567890"
                    required
                >
                @error('nomor_rekening')
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
                            {{ old('status', $transaksi->status) == 'Pending' ? 'checked' : '' }}
                        >
                        <label for="pending">Pending</label>
                    </div>
                    <div class="radio-option">
                        <input 
                            type="radio" 
                            id="success" 
                            name="status" 
                            value="Success"
                            {{ old('status', $transaksi->status) == 'Success' ? 'checked' : '' }}
                            onchange="checkStock()"
                        >
                        <label for="success">Success</label>
                    </div>
                    <div class="radio-option">
                        <input 
                            type="radio" 
                            id="failed" 
                            name="status" 
                            value="Failed"
                            {{ old('status', $transaksi->status) == 'Failed' ? 'checked' : '' }}
                        >
                        <label for="failed">Failed</label>
                    </div>
                </div>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                <i class='bx bx-x'></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class='bx bx-check'></i> Update Transaksi
            </button>
        </div>
    </form>
</div>

<script>
const originalStatus = '{{ $transaksi->status }}';

function updateTotal() {
    const select = document.getElementById('pesanan_id');
    const totalInput = document.getElementById('total_transaksi');
    
    if (select.value) {
        const selectedOption = select.options[select.selectedIndex];
        const total = selectedOption.getAttribute('data-total');
        totalInput.value = total;
    } else {
        totalInput.value = '';
    }
}

function checkStock() {
    const select = document.getElementById('pesanan_id');
    const statusSuccess = document.getElementById('success');
    
    // Hanya cek stok jika status berubah dari non-Success ke Success
    if (statusSuccess.checked && originalStatus !== 'Success' && select.value) {
        const selectedOption = select.options[select.selectedIndex];
        const stock = parseInt(selectedOption.getAttribute('data-stock'));
        const qty = parseInt(selectedOption.getAttribute('data-qty'));
        
        if (stock < qty) {
            alert('Perhatian: Stok produk tidak mencukupi!\n\nStok tersedia: ' + stock + '\nJumlah pesanan: ' + qty + '\n\nSilakan pilih status lain atau ubah pesanan.');
            // Kembalikan ke status original
            if (originalStatus === 'Pending') {
                document.getElementById('pending').checked = true;
            } else if (originalStatus === 'Failed') {
                document.getElementById('failed').checked = true;
            }
            return false;
        }
    }
    
    // Konfirmasi jika mengubah dari Success ke status lain
    if (!statusSuccess.checked && originalStatus === 'Success') {
        return confirm('Anda akan mengubah status dari Success ke status lain.\n\nIni akan:\n- Mengembalikan pesanan ke status Pending\n- Mengembalikan stok produk\n\nLanjutkan?');
    }
    
    return true;
}

// Validasi sebelum submit
document.getElementById('transaksiForm').addEventListener('submit', function(e) {
    if (!checkStock()) {
        e.preventDefault();
        return false;
    }
});

// Auto update on page load
window.onload = function() {
    updateTotal();
}
</script>

@endsection