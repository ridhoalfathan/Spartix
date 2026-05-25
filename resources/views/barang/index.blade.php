@extends('layouts.main')

@section('title', 'Data Barang - RAYA-E')

@section('content')
<!-- Alerts -->
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
    <h1 class="page-title">
        <i class="bi bi-box-seam-fill"></i>
        Data Barang
    </h1>
    <a href="{{ route('barang.create') }}" class="btn-primary">
        <i class="bi bi-plus-circle-fill"></i>
        Tambah Barang
    </a>
</div>

<!-- Filter Card -->
<div class="filter-card">
    <form action="{{ route('barang.index') }}" method="GET">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">🔍 Cari Barang</label>
                <input type="text" name="search" class="form-control" placeholder="Nama, kode, atau merk..." value="{{ request('search') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">📦 Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">Semua Kategori</option>
                    @if(isset($categories))
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">📊 Status Stok</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="normal" {{ request('status') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="rendah" {{ request('status') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            
            <div class="form-group" style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('barang.index') }}" class="btn-reset">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-responsive">
        @if($barang->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>KODE</th>
                    <th>NAMA BARANG</th>
                    <th>KATEGORI</th>
                    <th>MERK</th>
                    <th>HARGA</th>
                    <th>STOK</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang as $index => $item)
                <tr>
                    <td><strong>{{ $barang->firstItem() + $index }}</strong></td>
                    <td><strong style="color: #2563EB;">{{ $item->kode_barang }}</strong></td>
                    <td><strong>{{ $item->nama_barang }}</strong></td>
                    <td>
                        <span class="badge-category">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td>{{ $item->merk }}</td>
                    <td><strong style="color: #10b981;">{{ $item->harga_format }}</strong></td>
                    <td><strong style="color: #1e3a8a;">{{ $item->stok }}</strong> Unit</td>
                    <td>
                        @if($item->stok <= 0)
                            <span class="badge badge-danger">
                                <i class="bi bi-x-circle-fill"></i> Habis
                            </span>
                        @elseif($item->stok <= $item->stok_minimum)
                            <span class="badge badge-warning">
                                <i class="bi bi-exclamation-triangle-fill"></i> Rendah
                            </span>
                        @else
                            <span class="badge badge-success">
                                <i class="bi bi-check-circle-fill"></i> Normal
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('barang.show', $item->id) }}" class="btn-action btn-action-view" title="Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('barang.edit', $item->id) }}" class="btn-action btn-action-edit" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="bi bi-inbox-fill"></i>
            <h4>Tidak Ada Data</h4>
            <p>Belum ada barang yang terdaftar. Klik tombol "Tambah Barang" untuk menambah data.</p>
        </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($barang->count() > 0)
<div class="pagination-wrap">
    {{ $barang->links() }}
</div>
@endif
@endsection
