{{-- resources/views/laporan/buku-besar-detail.blade.php --}}
@extends('layouts.main')

@section('title', 'Detail Buku Besar - ' . $akun->nama_akun)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('laporan.buku-besar') }}">Buku Besar</a></li>
                <li class="breadcrumb-item active">Detail Akun</li>
            </ol>
        </nav>
        <h2 class="fw-bold mb-1" style="color: #1e40af;">
            <i class="bi bi-journal-bookmark-fill me-2"></i>Detail Buku Besar
        </h2>
        <p class="text-muted mb-0">Rincian transaksi: <strong>{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</strong></p>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('laporan.buku-besar.detail', $akun) }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" class="form-control" 
                           value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" class="form-control" 
                           value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('laporan.buku-besar.detail', $akun) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                    <button type="button" class="btn btn-success" onclick="exportPDF()">
                        <i class="bi bi-file-pdf"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Account Info Card -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Kode Akun</h6>
                    <h4 class="fw-bold mb-0">{{ $akun->kode_akun }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-primary bg-opacity-10">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Tipe Akun</h6>
                    @php
                        $badgeColors = [
                            'Aset' => 'success',
                            'Liabilitas' => 'danger',
                            'Ekuitas' => 'info',
                            'Pendapatan' => 'primary',
                            'Beban' => 'warning'
                        ];
                        $color = $badgeColors[$akun->tipe_akun] ?? 'secondary';
                    @endphp
                    <h4 class="mb-0">
                        <span class="badge bg-{{ $color }}">{{ $akun->tipe_akun }}</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-info bg-opacity-10">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Posisi Normal</h6>
                    <h4 class="mb-0">
                        <span class="badge {{ $akun->posisi_normal == 'Debit' ? 'bg-info' : 'bg-warning' }}">
                            {{ $akun->posisi_normal }}
                        </span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-success bg-opacity-10">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Saldo Awal</h6>
                    <h4 class="fw-bold mb-0">
                        Rp {{ number_format($akun->saldo_normal, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-list-ul me-2"></i>Rincian Transaksi
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 fw-bold">Tanggal</th>
                            <th class="px-4 py-3 fw-bold">No. Jurnal</th>
                            <th class="px-4 py-3 fw-bold">Keterangan</th>
                            <th class="px-4 py-3 fw-bold text-end">Debit</th>
                            <th class="px-4 py-3 fw-bold text-end">Kredit</th>
                            <th class="px-4 py-3 fw-bold text-end">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Saldo Awal -->
                        <tr class="bg-light">
                            <td class="px-4 py-3" colspan="3">
                                <strong>Saldo Awal</strong>
                            </td>
                            <td class="px-4 py-3 text-end">-</td>
                            <td class="px-4 py-3 text-end">-</td>
                            <td class="px-4 py-3 text-end">
                                <strong>Rp {{ number_format($akun->saldo_normal, 0, ',', '.') }}</strong>
                            </td>
                        </tr>

                        @forelse($detailsWithBalance as $item)
                        <tr>
                            <td class="px-4 py-3">
                                {{ $item['detail']->jurnalEntry->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $item['detail']->jurnalEntry->no_jurnal }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                {{ $item['detail']->keterangan ?? $item['detail']->jurnalEntry->keterangan }}
                            </td>
                            <td class="px-4 py-3 text-end">
                                @if($item['detail']->debit > 0)
                                <span class="fw-semibold text-success">
                                    Rp {{ number_format($item['detail']->debit, 0, ',', '.') }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                @if($item['detail']->kredit > 0)
                                <span class="fw-semibold text-danger">
                                    Rp {{ number_format($item['detail']->kredit, 0, ',', '.') }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <span class="badge {{ $item['saldo'] >= 0 ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                    Rp {{ number_format(abs($item['saldo']), 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox display-1 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-0">Belum ada transaksi untuk akun ini</p>
                            </td>
                        </tr>
                        @endforelse

                        @if(count($detailsWithBalance) > 0)
                        <!-- Saldo Akhir -->
                        <tr class="table-primary">
                            <td class="px-4 py-3" colspan="3">
                                <strong>SALDO AKHIR</strong>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <strong class="text-success">
                                    Rp {{ number_format(collect($detailsWithBalance)->sum('detail.debit'), 0, ',', '.') }}
                                </strong>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <strong class="text-danger">
                                    Rp {{ number_format(collect($detailsWithBalance)->sum('detail.kredit'), 0, ',', '.') }}
                                </strong>
                            </td>
                            <td class="px-4 py-3 text-end">
                                @php
                                    $saldoAkhir = end($detailsWithBalance)['saldo'] ?? $akun->saldo_normal;
                                @endphp
                                <strong class="badge {{ $saldoAkhir >= 0 ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                    Rp {{ number_format(abs($saldoAkhir), 0, ',', '.') }}
                                </strong>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="{{ route('laporan.buku-besar') }}" class="btn btn-lg btn-light">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Buku Besar
        </a>
    </div>
</div>

<style>
.card {
    border-radius: 14px;
}

.breadcrumb-item a {
    color: #2563EB;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.table thead th {
    border-bottom: 2px solid #e2e8f0;
    color: #475569;
    font-size: 0.875rem;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:not(.bg-light):not(.table-primary):hover {
    background-color: rgba(37, 99, 235, 0.02);
}

@media print {
    .btn, nav, form {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
        page-break-inside: avoid;
    }
    
    .breadcrumb {
        display: none;
    }
}
</style>

<script>
function exportPDF() {
    const url = new URL(window.location.href);
    url.searchParams.set('export', 'pdf');
    window.location.href = url.toString();
}
</script>
@endsection

