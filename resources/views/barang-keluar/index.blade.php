@extends('layouts.main')

@section('title', 'Barang Keluar - RAYA-E')

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
        <i class="bi bi-box-arrow-up-fill"></i>
        Barang Keluar (Penjualan)
    </h1>
    <a href="{{ route('barang-keluar.create') }}" class="btn-primary">
        <i class="bi bi-plus-circle"></i>
        Tambah Penjualan
    </a>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-responsive">
        @if($barangKeluar->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO TRANSAKSI</th>
                    <th>TANGGAL</th>
                    <th>BARANG</th>
                    <th>KATEGORI</th>
                    <th>SERIAL NUMBER</th>
                    <th>HPP</th>
                    <th>HARGA JUAL</th>
                    <th>CUSTOMER</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangKeluar as $index => $item)
                <tr>
                    <td>{{ $barangKeluar->firstItem() + $index }}</td>
                    <td><strong>{{ $item->nomor_transaksi }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $item->barang->nama_barang }}</strong><br>
                        <small style="color: #64748b;">{{ $item->barang->kode_barang }}</small>
                    </td>
                    <td>
                        <span class="badge-category">
                            {{ $item->barang->kategori }}
                        </span>
                    </td>
                    <td>
                        <span style="font-family: 'Courier New', monospace; font-weight: 700; color: #2563EB;">
                            {{ $item->serialNumber->serial_number }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($item->hpp, 0, ',', '.') }}</td>
                    <td><strong>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</strong></td>
                    <td>{{ $item->customer ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('barang-keluar.show', $item->id) }}" class="btn-action btn-action-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('barang-keluar.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok akan dikembalikan!')">
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
            <p>Belum ada transaksi penjualan. Klik tombol "Tambah Penjualan" untuk menambah data.</p>
        </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($barangKeluar->count() > 0)
<div class="pagination-wrap">
    {{ $barangKeluar->links('pagination::bootstrap-5') }}
</div>
@endif
@endsection
