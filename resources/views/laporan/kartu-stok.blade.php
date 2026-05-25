@extends('layouts.main')

@section('title', 'Kartu Stok - RAYA-E')

@section('styles')
<style>
    /* ── Page Layout ── */
    .page-header {
        background: white; padding: 1.5rem 2rem; border-radius: 16px;
        margin-bottom: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        display: flex; justify-content: space-between; align-items: center;
    }
    .page-title { font-size: 1.6rem; font-weight: 800; color: #1e3a8a; display: flex; align-items: center; gap: 10px; margin: 0; }
    .page-title i { color: #2563EB; }

    /* ── Filter ── */
    .filter-card { background: white; padding: 1.25rem 1.5rem; border-radius: 14px; margin-bottom: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.07); }
    .form-label { font-weight: 600; color: #475569; font-size: 0.82rem; margin-bottom: 0.35rem; display: block; text-transform: uppercase; letter-spacing: 0.4px; }
    .form-control, .form-select { border: 2px solid #e2e8f0; border-radius: 9px; padding: 0.55rem 0.9rem; font-size: 0.88rem; width: 100%; transition: border-color 0.2s; }
    .form-control:focus, .form-select:focus { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); outline: none; }
    .btn-filter { background: #2563EB; color: white; padding: 0.55rem 1.25rem; border-radius: 9px; border: none; font-weight: 600; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; }
    .btn-filter:hover { background: #1d4ed8; }
    .btn-reset { background: #94a3b8; color: white; padding: 0.55rem 1rem; border-radius: 9px; border: none; font-weight: 600; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-reset:hover { background: #64748b; color: white; }
    .btn-export-pdf { padding: 0.55rem 1.25rem; border-radius: 9px; font-weight: 700; font-size: 0.88rem; border: none; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; box-shadow: 0 3px 10px rgba(239,68,68,0.3); display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
    .btn-export-pdf:hover { transform: translateY(-1px); color: white; box-shadow: 0 5px 14px rgba(239,68,68,0.4); }

    /* ── Summary Cards ── */
    .info-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .info-card { background: white; padding: 1rem 1.25rem; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.06); border-left: 4px solid #2563EB; }
    .info-card.pembelian { border-left-color: #16a34a; }
    .info-card.penjualan { border-left-color: #dc2626; }
    .info-card.saldo     { border-left-color: #d97706; }
    .info-card-label { font-size: 0.72rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.3rem; }
    .info-card-value { font-size: 1.2rem; font-weight: 800; color: #1e3a8a; }
    .info-card-sub { font-size: 0.75rem; color: #64748b; margin-top: 0.15rem; }

    /* ── Kartu Header ── */
    .kartu-wrap { border-radius: 14px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.1); margin-bottom: 1rem; }
    .kartu-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563EB 100%);
        color: white; padding: 1rem 1.5rem;
        display: flex; justify-content: space-between; align-items: center;
    }
    .kartu-header h5 { margin: 0; font-weight: 800; font-size: 1rem; letter-spacing: 0.3px; }
    .kartu-header .sub-info { font-size: 0.8rem; opacity: 0.88; margin-top: 3px; }
    .kartu-header .right-info { text-align: right; font-size: 0.8rem; opacity: 0.9; line-height: 1.6; }

    /* ── Table ── */
    .table-responsive { overflow-x: auto; }
    table.kartu-table {
        width: 100%; border-collapse: collapse;
        background: white; font-size: 0.83rem;
        table-layout: fixed;
    }
    /* Column widths */
    table.kartu-table col.c-tgl    { width: 90px; }
    table.kartu-table col.c-ket    { width: 200px; }
    table.kartu-table col.c-qty    { width: 55px; }
    table.kartu-table col.c-harga  { width: 105px; }
    table.kartu-table col.c-jumlah { width: 115px; }

    /* Header rows */
    table.kartu-table thead tr.tr-group th {
        padding: 9px 10px; font-weight: 800; font-size: 0.75rem;
        text-transform: uppercase; letter-spacing: 0.4px;
        border: 1px solid rgba(255,255,255,0.2); text-align: center; color: white;
    }
    table.kartu-table thead tr.tr-group th.th-info   { background: #1e3a8a; }
    table.kartu-table thead tr.tr-group th.th-masuk  { background: #16a34a; }
    table.kartu-table thead tr.tr-group th.th-keluar { background: #dc2626; }
    table.kartu-table thead tr.tr-group th.th-saldo  { background: #d97706; }

    table.kartu-table thead tr.tr-sub th {
        padding: 7px 10px; font-weight: 700; font-size: 0.7rem;
        text-transform: uppercase; letter-spacing: 0.3px;
        border: 1px solid #e2e8f0;
    }
    table.kartu-table thead tr.tr-sub th.sub-info   { background: #f1f5f9; color: #1e3a8a; }
    table.kartu-table thead tr.tr-sub th.sub-masuk  { background: #f0fdf4; color: #16a34a; }
    table.kartu-table thead tr.tr-sub th.sub-keluar { background: #fff7f7; color: #dc2626; }
    table.kartu-table thead tr.tr-sub th.sub-saldo  { background: #fffbeb; color: #d97706; }

    /* Body cells */
    table.kartu-table tbody td {
        padding: 8px 10px; border: 1px solid #f0f4f8;
        vertical-align: middle; color: #1e293b; line-height: 1.5;
    }
    table.kartu-table tbody tr:hover td { background: rgba(37,99,235,0.025); }

    /* Row types */
    table.kartu-table tbody tr.row-saldo-awal td { background: #eff6ff; font-weight: 700; color: #1e40af; }
    table.kartu-table tbody tr.row-masuk  td { background: #f9fefb; }
    table.kartu-table tbody tr.row-keluar td { background: #fff9f9; }
    table.kartu-table tbody tr.row-total  td {
        background: #f1f5f9; font-weight: 800; color: #1e3a8a;
        border-top: 2px solid #1e3a8a; padding: 10px;
    }

    /* Layer lines */
    .layer-line { display: block; white-space: nowrap; line-height: 1.8; font-size: 0.82rem; }
    .layer-masuk  { color: #16a34a; font-weight: 600; }
    .layer-keluar { color: #dc2626; font-weight: 600; }
    .layer-saldo  { color: #92400e; }

    .dash { color: #cbd5e1; display: block; text-align: center; }

    /* Badges */
    .badge-pembelian { background: #d1fae5; color: #065f46; padding: 2px 7px; border-radius: 5px; font-size: 0.68rem; font-weight: 700; display: inline-block; margin-top: 2px; }
    .badge-penjualan { background: #fecaca; color: #991b1b; padding: 2px 7px; border-radius: 5px; font-size: 0.68rem; font-weight: 700; display: inline-block; margin-top: 2px; }

    /* Empty / note */
    .empty-state { text-align: center; padding: 4rem 2rem; background: white; border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.07); }
    .empty-state i { font-size: 3.5rem; color: #cbd5e1; margin-bottom: 1rem; display: block; }
    .empty-state h4 { color: #1e3a8a; font-weight: 800; }
    .note-fifo { margin-top: 0.75rem; font-size: 0.78rem; color: #64748b; font-style: italic; }

    @media (max-width: 768px) { .page-header { flex-direction: column; gap: 1rem; } .info-grid { grid-template-columns: 1fr 1fr; } }
    @media print { .filter-card, .btn-export-pdf, .btn-reset, .btn-filter { display: none !important; } }
</style>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-card-list"></i> Kartu Stok</h1>
    @if($kartuStok)
    <a href="{{ route('laporan.kartu-stok') }}?export=pdf&barang_id={{ request('barang_id') }}&tanggal_dari={{ $tanggalDari }}&tanggal_sampai={{ $tanggalSampai }}"
       class="btn-export-pdf">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
    @endif
</div>

{{-- Filter --}}
<div class="filter-card">
    <form action="{{ route('laporan.kartu-stok') }}" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Pilih Barang <span style="color:#ef4444">*</span></label>
                <select name="barang_id" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangList as $b)
                        <option value="{{ $b->id }}" {{ request('barang_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->kode_barang }} - {{ $b->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Dari</label>
                <input type="date" name="tanggal_dari" class="form-control" value="{{ $tanggalDari }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Sampai</label>
                <input type="date" name="tanggal_sampai" class="form-control" value="{{ $tanggalSampai }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn-filter flex-fill">
                    <i class="bi bi-search"></i> Tampilkan
                </button>
                <a href="{{ route('laporan.kartu-stok') }}" class="btn-reset">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

@if($kartuStok)

{{-- Summary Cards --}}
<div class="info-grid">
    <div class="info-card">
        <div class="info-card-label">Saldo Awal</div>
        <div class="info-card-value">{{ number_format($kartuStok['saldo_awal_qty']) }} Unit</div>
        <div class="info-card-sub">Rp {{ number_format($kartuStok['saldo_awal_nilai'], 0, ',', '.') }}</div>
    </div>
    <div class="info-card pembelian">
        <div class="info-card-label">Total Pembelian</div>
        <div class="info-card-value" style="color:#16a34a">{{ number_format($kartuStok['total_masuk_qty']) }} Unit</div>
        <div class="info-card-sub">Rp {{ number_format($kartuStok['total_masuk_nilai'], 0, ',', '.') }}</div>
    </div>
    <div class="info-card penjualan">
        <div class="info-card-label">Total Penjualan (HPP)</div>
        <div class="info-card-value" style="color:#dc2626">{{ number_format($kartuStok['total_keluar_qty']) }} Unit</div>
        <div class="info-card-sub">Rp {{ number_format($kartuStok['total_keluar_nilai'], 0, ',', '.') }}</div>
    </div>
    <div class="info-card saldo">
        <div class="info-card-label">Saldo Akhir</div>
        <div class="info-card-value" style="color:#d97706">{{ number_format($kartuStok['saldo_akhir_qty']) }} Unit</div>
        <div class="info-card-sub">Rp {{ number_format($kartuStok['saldo_akhir_nilai'], 0, ',', '.') }}</div>
    </div>
</div>

{{-- Kartu Stok Table --}}
<div class="kartu-wrap">
    {{-- Header --}}
    <div class="kartu-header">
        <div>
            <h5><i class="bi bi-table me-2"></i>KARTU STOK BARANG — METODE FIFO</h5>
            <div class="sub-info">
                {{ $kartuStok['barang']->kode_barang }} — {{ $kartuStok['barang']->nama_barang }}
                &nbsp;|&nbsp; Periode: {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }}
                s/d {{ \Carbon\Carbon::parse($tanggalSampai)->format('d/m/Y') }}
            </div>
        </div>
        <div class="right-info">
            <div>Kategori: <strong>{{ $kartuStok['barang']->kategori }}</strong></div>
            <div>Merk: <strong>{{ $kartuStok['barang']->merk }}</strong></div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="kartu-table">
            <colgroup>
                <col class="c-tgl">
                <col class="c-ket">
                {{-- Masuk --}}
                <col class="c-qty"><col class="c-harga"><col class="c-jumlah">
                {{-- Keluar --}}
                <col class="c-qty"><col class="c-harga"><col class="c-jumlah">
                {{-- Saldo --}}
                <col class="c-qty"><col class="c-harga"><col class="c-jumlah">
            </colgroup>
            <thead>
                <tr class="tr-group">
                    <th class="th-info" rowspan="2" style="vertical-align:middle;text-align:center;">TANGGAL</th>
                    <th class="th-info" rowspan="2" style="vertical-align:middle;">KETERANGAN</th>
                    <th class="th-masuk"  colspan="3">PEMBELIAN (MASUK)</th>
                    <th class="th-keluar" colspan="3">PENJUALAN (KELUAR)</th>
                    <th class="th-saldo"  colspan="3">SALDO STOK</th>
                </tr>
                <tr class="tr-sub">
                    <th class="sub-masuk  text-center">QTY</th>
                    <th class="sub-masuk  text-end">HARGA/UNIT</th>
                    <th class="sub-masuk  text-end">JUMLAH</th>
                    <th class="sub-keluar text-center">QTY</th>
                    <th class="sub-keluar text-end">HARGA/UNIT</th>
                    <th class="sub-keluar text-end">JUMLAH</th>
                    <th class="sub-saldo  text-center">QTY</th>
                    <th class="sub-saldo  text-end">HARGA/UNIT</th>
                    <th class="sub-saldo  text-end">JUMLAH</th>
                </tr>
            </thead>
            <tbody>

                {{-- ══ SALDO AWAL ══ --}}
                <tr class="row-saldo-awal">
                    <td class="text-center fw-bold">
                        {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }}
                    </td>
                    <td><strong>SALDO AWAL</strong></td>
                    {{-- Masuk: kosong --}}
                    <td><span class="dash">—</span></td>
                    <td><span class="dash">—</span></td>
                    <td><span class="dash">—</span></td>
                    {{-- Keluar: kosong --}}
                    <td><span class="dash">—</span></td>
                    <td><span class="dash">—</span></td>
                    <td><span class="dash">—</span></td>
                    {{-- Saldo layers --}}
                    @php $layers = $kartuStok['saldo_awal_layers']; @endphp
                    <td class="text-center">
                        @forelse($layers as $l)
                            <span class="layer-line layer-saldo">{{ number_format($l['qty']) }} pcs</span>
                        @empty
                            <span class="dash">—</span>
                        @endforelse
                    </td>
                    <td class="text-end">
                        @forelse($layers as $l)
                            <span class="layer-line layer-saldo">{{ number_format($l['harga'], 0, ',', '.') }}</span>
                        @empty
                            <span class="dash">—</span>
                        @endforelse
                    </td>
                    <td class="text-end">
                        @forelse($layers as $l)
                            <span class="layer-line layer-saldo">{{ number_format($l['nilai'], 0, ',', '.') }}</span>
                        @empty
                            <span class="dash">—</span>
                        @endforelse
                    </td>
                </tr>

                {{-- ══ MUTASI ══ --}}
                @forelse($kartuStok['rows'] as $row)
                <tr class="row-{{ $row['tipe'] }}">
                    <td class="text-center" style="color:#2563EB;font-weight:600;">
                        {{ \Carbon\Carbon::parse($row['tanggal'])->format('d/m/Y') }}
                    </td>
                    <td>
                        <div>{{ $row['keterangan'] }}</div>
                        <span class="badge-{{ $row['tipe'] === 'masuk' ? 'pembelian' : 'penjualan' }}">
                            {{ $row['tipe'] === 'masuk' ? 'Pembelian' : 'Penjualan' }}
                        </span>
                    </td>

                    @if($row['tipe'] === 'masuk')
                        {{-- ── MASUK ── --}}
                        @php $ml = $row['masuk_layers'][0] ?? null; @endphp
                        <td class="text-center">
                            @if($ml)<span class="layer-line layer-masuk">{{ number_format($ml['qty']) }}</span>
                            @else<span class="dash">—</span>@endif
                        </td>
                        <td class="text-end">
                            @if($ml)<span class="layer-line layer-masuk">{{ number_format($ml['harga'], 0, ',', '.') }}</span>
                            @else<span class="dash">—</span>@endif
                        </td>
                        <td class="text-end">
                            @if($ml)
                                <span class="layer-line layer-masuk">{{ number_format($ml['nilai'], 0, ',', '.') }}</span>
                            @else<span class="dash">—</span>@endif
                        </td>
                        {{-- Keluar: kosong --}}
                        <td><span class="dash">—</span></td>
                        <td><span class="dash">—</span></td>
                        <td><span class="dash">—</span></td>

                    @else
                        {{-- ── KELUAR ── --}}
                        <td><span class="dash">—</span></td>
                        <td><span class="dash">—</span></td>
                        <td><span class="dash">—</span></td>
                        @php $kl = $row['keluar_layers']; @endphp
                        <td class="text-center">
                            @foreach($kl as $l)
                                <span class="layer-line layer-keluar">{{ number_format($l['qty']) }} pcs</span>
                            @endforeach
                        </td>
                        <td class="text-end">
                            @foreach($kl as $l)
                                <span class="layer-line layer-keluar">{{ number_format($l['harga'], 0, ',', '.') }}</span>
                            @endforeach
                        </td>
                        <td class="text-end">
                            @foreach($kl as $l)
                                <span class="layer-line layer-keluar">{{ number_format($l['nilai'], 0, ',', '.') }}</span>
                            @endforeach
                        </td>
                    @endif

                    {{-- ── SALDO ── --}}
                    @php $sl = $row['saldo_layers']; @endphp
                    <td class="text-center">
                        @forelse($sl as $l)
                            <span class="layer-line layer-saldo">{{ number_format($l['qty']) }} pcs</span>
                        @empty
                            <span class="dash">—</span>
                        @endforelse
                    </td>
                    <td class="text-end">
                        @forelse($sl as $l)
                            <span class="layer-line layer-saldo">{{ number_format($l['harga'], 0, ',', '.') }}</span>
                        @empty
                            <span class="dash">—</span>
                        @endforelse
                    </td>
                    <td class="text-end">
                        @forelse($sl as $l)
                            <span class="layer-line layer-saldo">{{ number_format($l['nilai'], 0, ',', '.') }}</span>
                        @empty
                            <span class="dash">—</span>
                        @endforelse
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-4" style="color:#94a3b8;">
                        <i class="bi bi-inbox me-2"></i>Tidak ada mutasi dalam periode ini
                    </td>
                </tr>
                @endforelse

                {{-- ══ TOTAL ══ --}}
                <tr class="row-total">
                    <td colspan="2" class="text-end" style="font-size:0.85rem;">TOTAL MUTASI PERIODE</td>
                    <td class="text-center">{{ number_format($kartuStok['total_masuk_qty']) }}</td>
                    <td></td>
                    <td class="text-end" style="color:#16a34a;">
                        Rp {{ number_format($kartuStok['total_masuk_nilai'], 0, ',', '.') }}
                    </td>
                    <td class="text-center">{{ number_format($kartuStok['total_keluar_qty']) }}</td>
                    <td></td>
                    <td class="text-end" style="color:#dc2626;">
                        Rp {{ number_format($kartuStok['total_keluar_nilai'], 0, ',', '.') }}
                    </td>
                    <td class="text-center">{{ number_format($kartuStok['saldo_akhir_qty']) }}</td>
                    <td></td>
                    <td class="text-end" style="color:#d97706;">
                        Rp {{ number_format($kartuStok['saldo_akhir_nilai'], 0, ',', '.') }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<p class="note-fifo">
    * Metode <strong>First-In, First-Out (FIFO)</strong>: unit yang masuk pertama dikeluarkan pertama.
    Kolom Saldo menampilkan sisa stok per layer harga beli.
    Kolom Penjualan menampilkan layer mana yang diambil sesuai urutan FIFO.
</p>

@elseif(request()->has('barang_id'))
<div class="empty-state">
    <i class="bi bi-exclamation-circle"></i>
    <h4>Barang Tidak Ditemukan</h4>
    <p>Silakan pilih barang yang valid.</p>
</div>
@else
<div class="empty-state">
    <i class="bi bi-card-list"></i>
    <h4>Pilih Barang untuk Menampilkan Kartu Stok</h4>
    <p>Pilih barang dan periode di atas, lalu klik <strong>Tampilkan</strong>.</p>
</div>
@endif

@endsection
