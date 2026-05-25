@extends('layouts.main')

@section('title', 'Edit Akun - RAYA-E')

@section('styles')
<style>
    .page-header {
        background: #ffffff;
        padding: 1.75rem 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(37,99,235,0.08);
        border: 1px solid rgba(37,99,235,0.1);
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
    .page-title i { color: #f59e0b; font-size: 2rem; }
    .breadcrumb { background: none; padding: 0; margin-top: 0.5rem; font-size: 0.9rem; }
    .breadcrumb-item { display: inline-block; }
    .breadcrumb-item + .breadcrumb-item::before { content: "/"; padding: 0 0.5rem; color: #cbd5e1; }
    .breadcrumb-item a { color: #2563EB; text-decoration: none; font-weight: 700; }
    .breadcrumb-item.active { color: #64748b; font-weight: 600; }
    .form-card {
        background: #ffffff;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37,99,235,0.08);
        border: 1px solid rgba(37,99,235,0.1);
    }
    .form-group { margin-bottom: 1.5rem; }
    .form-label {
        font-weight: 700; color: #1e3a8a; margin-bottom: 0.5rem;
        display: block; font-size: 0.875rem;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .form-label .required { color: #ef4444; }
    .form-control, .form-select {
        border: 2px solid #e2e8f0; border-radius: 10px;
        padding: 0.75rem 1rem; font-size: 0.95rem;
        transition: all 0.3s ease; width: 100%; font-weight: 500;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
        outline: none;
    }
    .form-text { font-size: 0.85rem; color: #64748b; margin-top: 0.5rem; display: block; }
    .invalid-feedback { color: #ef4444; font-size: 0.85rem; margin-top: 0.5rem; display: block; font-weight: 600; }
    .is-invalid { border-color: #ef4444 !important; }
    .input-group { position: relative; }
    .currency-icon {
        position: absolute; left: 1rem; top: 50%;
        transform: translateY(-50%);
        color: #2563EB; font-weight: 800; pointer-events: none; z-index: 1;
    }
    .form-control.with-currency { padding-left: 2.75rem; }
    .btn-group {
        display: flex; gap: 1rem; justify-content: flex-end;
        margin-top: 2rem; padding-top: 2rem;
        border-top: 2px solid #f1f5f9;
    }
    .btn {
        padding: 0.75rem 2rem; border-radius: 10px; font-weight: 700;
        border: none; transition: all 0.3s ease;
        display: inline-flex; align-items: center; gap: 8px;
        cursor: pointer; text-decoration: none;
    }
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.25);
    }
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(245,158,11,0.35);
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        color: white;
    }
    .btn-secondary { background: #94a3b8; color: white; }
    .btn-secondary:hover { background: #64748b; transform: translateY(-2px); color: white; }
    .alert {
        padding: 1.25rem 1.5rem; border-radius: 14px;
        margin-bottom: 2rem; border: none; font-weight: 600;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .alert-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; }
    .alert-danger ul { margin: 0.75rem 0 0 1.25rem; padding: 0; }
    .alert-danger li { margin: 0.25rem 0; }
    .meta-info {
        background: linear-gradient(135deg, rgba(100,116,139,0.08) 0%, rgba(71,85,105,0.08) 100%);
        border: 2px solid rgba(100,116,139,0.15);
        border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;
    }
    .meta-info h6 { color: #1e3a8a; font-weight: 800; font-size: 0.95rem; margin-bottom: 1rem; }
    .meta-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 0.5rem 0; border-bottom: 1px solid rgba(100,116,139,0.15);
    }
    .meta-item:last-child { border-bottom: none; }
    .meta-item small { color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; }
    .meta-item strong { color: #1e3a8a; font-size: 0.9rem; }
    .info-box {
        background: linear-gradient(135deg, rgba(37,99,235,0.08) 0%, rgba(30,64,175,0.08) 100%);
        color: #1e3a8a; border-left: 4px solid #2563EB;
        padding: 1.25rem 1.5rem; border-radius: 12px;
        display: flex; align-items: start; gap: 0.875rem;
        font-weight: 600; margin-bottom: 1.5rem;
    }
    .info-box i { font-size: 1.5rem; margin-top: 0.125rem; color: #2563EB; }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-pencil-square"></i>
        Edit Akun
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('akun.index') }}">Akun</a></li>
            <li class="breadcrumb-item active">Edit Akun</li>
        </ol>
    </nav>
</div>

<div class="form-card">
    @if($errors->any())
    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i> Oops!</strong> Ada beberapa masalah:
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="meta-info">
        <h6><i class="bi bi-info-circle-fill me-2"></i>Informasi Akun</h6>
        <div class="meta-item">
            <small>Kode Akun</small>
            <strong>{{ $akun->kode_akun }}</strong>
        </div>
        <div class="meta-item">
            <small>Nama Akun</small>
            <strong>{{ $akun->nama_akun }}</strong>
        </div>
    </div>

    <form action="{{ route('akun.update', $akun) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Kode Akun <span class="required">*</span></label>
                    <input type="text" name="kode_akun"
                           class="form-control @error('kode_akun') is-invalid @enderror"
                           value="{{ old('kode_akun', $akun->kode_akun) }}" required>
                    <small class="form-text">Format: angka atau kombinasi angka-huruf</small>
                    @error('kode_akun')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Nama Akun <span class="required">*</span></label>
                    <input type="text" name="nama_akun"
                           class="form-control @error('nama_akun') is-invalid @enderror"
                           value="{{ old('nama_akun', $akun->nama_akun) }}" required>
                    @error('nama_akun')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Tipe Akun <span class="required">*</span></label>
                    <select name="tipe_akun" class="form-select @error('tipe_akun') is-invalid @enderror" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Aset"       {{ old('tipe_akun', $akun->tipe_akun) == 'Aset'       ? 'selected' : '' }}>Aset</option>
                        <option value="Liabilitas" {{ old('tipe_akun', $akun->tipe_akun) == 'Liabilitas' ? 'selected' : '' }}>Liabilitas</option>
                        <option value="Ekuitas"    {{ old('tipe_akun', $akun->tipe_akun) == 'Ekuitas'    ? 'selected' : '' }}>Ekuitas</option>
                        <option value="Pendapatan" {{ old('tipe_akun', $akun->tipe_akun) == 'Pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                        <option value="Beban"      {{ old('tipe_akun', $akun->tipe_akun) == 'Beban'      ? 'selected' : '' }}>Beban</option>
                    </select>
                    @error('tipe_akun')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                        <option value="">-- Pilih Kategori (Opsional) --</option>
                        <option value="Lancar"          {{ old('kategori', $akun->kategori) == 'Lancar'          ? 'selected' : '' }}>Lancar</option>
                        <option value="Tidak Lancar"    {{ old('kategori', $akun->kategori) == 'Tidak Lancar'    ? 'selected' : '' }}>Tidak Lancar</option>
                        <option value="Operasional"     {{ old('kategori', $akun->kategori) == 'Operasional'     ? 'selected' : '' }}>Operasional</option>
                        <option value="Non-Operasional" {{ old('kategori', $akun->kategori) == 'Non-Operasional' ? 'selected' : '' }}>Non-Operasional</option>
                    </select>
                    @error('kategori')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Posisi Normal <span class="required">*</span></label>
                    <select name="posisi_normal" class="form-select @error('posisi_normal') is-invalid @enderror" required>
                        <option value="">-- Pilih Posisi --</option>
                        <option value="Debit"  {{ old('posisi_normal', $akun->posisi_normal) == 'Debit'  ? 'selected' : '' }}>Debit</option>
                        <option value="Kredit" {{ old('posisi_normal', $akun->posisi_normal) == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                    </select>
                    <small class="form-text">Aset & Beban = Debit &nbsp;|&nbsp; Liabilitas, Ekuitas & Pendapatan = Kredit</small>
                    @error('posisi_normal')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Saldo Normal <span class="required">*</span></label>
                    <div class="input-group">
                        <span class="currency-icon">Rp</span>
                        <input type="text" name="saldo_display" id="saldo-input"
                               class="form-control with-currency @error('saldo_normal') is-invalid @enderror"
                               value="{{ number_format($akun->saldo_normal, 0, ',', '.') }}" required>
                        <input type="hidden" name="saldo_normal" id="saldo-hidden" value="{{ $akun->saldo_normal }}">
                    </div>
                    @error('saldo_normal')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="info-box">
            <i class="bi bi-info-circle-fill"></i>
            <div>Perubahan pada akun yang memiliki transaksi terkait perlu dilakukan dengan hati-hati untuk menjaga integritas data.</div>
        </div>

        <div class="btn-group">
            <a href="{{ route('akun.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle-fill"></i> Batal
            </a>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save-fill"></i> Update Akun
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const saldoInput  = document.getElementById('saldo-input');
    const saldoHidden = document.getElementById('saldo-hidden');
    if (saldoInput && saldoHidden) {
        saldoInput.addEventListener('input', function () {
            let val = this.value.replace(/[^\d]/g, '');
            this.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            saldoHidden.value = val;
        });
        saldoInput.addEventListener('blur', function () {
            if (!this.value || this.value === '0') { this.value = '0'; saldoHidden.value = '0'; }
        });
    }
});
</script>
@endsection
