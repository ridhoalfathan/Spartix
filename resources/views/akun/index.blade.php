@extends('layouts.main')

@section('title', 'Akun - RAYA-E')

@section('content')
@if(session('success'))
<div class="alert-box alert-box-success">
    <i class="bi bi-check-circle-fill"></i>
    <span>{{ session('success') }}</span>
</div>
@endif
@if(session('error'))
<div class="alert-box alert-box-danger">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-journal-text"></i>
            Akun
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin-top: 0.25rem; font-weight: 500; margin-bottom: 0;">Kelola daftar akun keuangan perusahaan</p>
    </div>
    <a href="{{ route('akun.create') }}" class="btn-primary">
        <i class="bi bi-plus-circle-fill"></i>
        Tambah Akun
    </a>
</div>

<!-- Filter -->
<div class="filter-card">
    <form action="{{ route('akun.index') }}" method="GET">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">🔍 Cari Akun</label>
                <input type="text" name="search" class="form-control"
                       placeholder="Kode atau nama akun..."
                       value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <label class="form-label">📊 Tipe Akun</label>
                <select name="tipe_akun" class="form-control">
                    <option value="">Semua Tipe</option>
                    <option value="Aset"       {{ request('tipe_akun') == 'Aset'       ? 'selected' : '' }}>Aset</option>
                    <option value="Liabilitas" {{ request('tipe_akun') == 'Liabilitas' ? 'selected' : '' }}>Liabilitas</option>
                    <option value="Ekuitas"    {{ request('tipe_akun') == 'Ekuitas'    ? 'selected' : '' }}>Ekuitas</option>
                    <option value="Pendapatan" {{ request('tipe_akun') == 'Pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                    <option value="Beban"      {{ request('tipe_akun') == 'Beban'      ? 'selected' : '' }}>Beban</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">✅ Status</label>
                <select name="is_active" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="form-group" style="display:flex;gap:0.5rem;">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('akun.index') }}" class="btn-reset">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Table -->
<div class="table-card">
    <div class="table-responsive">
        @if($akunList->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>KODE AKUN</th>
                    <th>NAMA AKUN</th>
                    <th>TIPE</th>
                    <th>KATEGORI</th>
                    <th>POSISI NORMAL</th>
                    <th>SALDO NORMAL</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($akunList as $index => $akun)
                <tr>
                    <td><strong>{{ $akunList->firstItem() + $index }}</strong></td>
                    <td><strong style="color:#2563EB;">{{ $akun->kode_akun }}</strong></td>
                    <td>
                        <div><strong>{{ $akun->nama_akun }}</strong></div>
                        @if($akun->parent)
                        <div style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem;">
                            <i class="bi bi-arrow-return-right"></i> {{ $akun->parent->nama_akun }}
                        </div>
                        @endif
                    </td>
                    <td><strong>{{ $akun->tipe_akun }}</strong></td>
                    <td>{{ $akun->kategori ?? '-' }}</td>
                    <td><strong>{{ $akun->posisi_normal }}</strong></td>
                    <td><strong style="color:#10b981;">Rp {{ number_format($akun->saldo_normal, 0, ',', '.') }}</strong></td>
                    <td>
                        @if($akun->is_active)
                        <span class="badge badge-success">
                            <i class="bi bi-check-circle-fill"></i> Aktif
                        </span>
                        @else
                        <span class="badge badge-danger">
                            <i class="bi bi-x-circle-fill"></i> Nonaktif
                        </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('akun.edit', $akun) }}" class="btn-action btn-action-edit" title="Edit">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="bi bi-inbox-fill"></i>
            <h4>Tidak Ada Data</h4>
            <p>Belum ada akun yang terdaftar. Klik "Tambah Akun" untuk menambah data.</p>
        </div>
        @endif
    </div>
</div>

@if($akunList->count() > 0)
<div class="pagination-wrap">
    {{ $akunList->links() }}
</div>
@endif
@endsection
