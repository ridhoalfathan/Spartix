@extends('layouts.main')

@section('title', 'Barang Masuk - RAYA-E')

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
        <i class="bi bi-box-arrow-in-down-fill"></i>
        Barang Masuk
    </h1>
    <a href="{{ route('barang-masuk.create') }}" class="btn-primary">
        <i class="bi bi-plus-circle"></i>
        Tambah Barang Masuk
    </a>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-responsive">
        @if($barangMasuk->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO TRANSAKSI</th>
                    <th>TANGGAL</th>
                    <th>BARANG</th>
                    <th>KATEGORI</th>
                    <th>JUMLAH</th>
                    <th>HARGA BELI</th>
                    <th>TOTAL</th>
                    <th>SUPPLIER</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangMasuk as $index => $item)
                <tr>
                    <td>{{ $barangMasuk->firstItem() + $index }}</td>
                    <td>
                        <strong style="font-family: 'Courier New', monospace; color: #2563EB;">
                            {{ $item->nomor_transaksi }}
                        </strong>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $item->barang->nama_barang }}</strong><br>
                        <small style="color: #64748b;">{{ $item->barang->kode_barang }}</small>
                    </td>
                    <td>
                        <span class="badge-category">
                            {{ $item->barang->kategori }}
                        </span>
                    </td>
                    <td><strong>{{ $item->jumlah }}</strong> Unit</td>
                    <td style="color: #ef4444; font-weight: 600;">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td><strong style="color: #10b981;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></td>
                    <td>{{ $item->supplier ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('barang-masuk.show', $item->id) }}" class="btn-action btn-action-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('barang-masuk.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Serial numbers akan ikut terhapus!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h4>Tidak Ada Data</h4>
            <p>Belum ada transaksi barang masuk. Klik tombol "Tambah Barang Masuk" untuk menambah data.</p>
        </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($barangMasuk->count() > 0)
<div class="pagination-wrap">
    {{ $barangMasuk->links() }}
</div>
@endif
@endsection
