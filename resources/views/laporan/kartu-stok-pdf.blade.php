<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Stok - {{ $kartuStok['barang']->nama_barang }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 18px 22px;
            color: #1e293b;
        }

        /* ── Header ── */
        .header {
            text-align: center;
            margin-bottom: 14px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 10px;
        }
        .header h1 { margin: 0; color: #1e3a8a; font-size: 20px; font-weight: bold; }
        .header h2 { margin: 4px 0 0; color: #475569; font-size: 13px; font-weight: normal; }

        /* ── Info Barang ── */
        .info-table {
            width: 100%;
            margin-bottom: 12px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 6px;
            font-size: 9.5px;
            border: none;
        }
        .info-table .label { font-weight: bold; color: #475569; width: 120px; }
        .info-table .value { color: #1e3a8a; }
        .info-box {
            background: #f1f5f9;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 12px;
        }

        /* ── Summary Cards ── */
        .summary-row {
            display: table;
            width: 100%;
            margin-bottom: 14px;
            border-spacing: 6px;
        }
        .summary-cell {
            display: table-cell;
            width: 25%;
            padding: 8px 10px;
            border-radius: 6px;
            text-align: center;
        }
        .summary-cell.awal     { background: #dbeafe; }
        .summary-cell.pembelian { background: #d1fae5; }
        .summary-cell.penjualan { background: #fecaca; }
        .summary-cell.saldo    { background: #fef3c7; }
        .summary-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            color: #475569;
            margin-bottom: 4px;
        }
        .summary-value {
            font-size: 13px;
            font-weight: bold;
            color: #1e3a8a;
        }
        .summary-sub { font-size: 8px; color: #64748b; margin-top: 2px; }

        /* ── Kartu Stok Table ── */
        table.kartu {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        table.kartu thead tr.group-header th {
            background: #1e3a8a;
            color: white;
            padding: 7px 5px;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            border: 1px solid #1e3a8a;
        }
        table.kartu thead tr.sub-header th {
            padding: 5px 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #cbd5e1;
        }
        table.kartu thead tr.sub-header th.pembelian-col { background: #d1fae5; color: #065f46; }
        table.kartu thead tr.sub-header th.penjualan-col { background: #fecaca; color: #991b1b; }
        table.kartu thead tr.sub-header th.saldo-col     { background: #fef3c7; color: #92400e; }
        table.kartu thead tr.sub-header th.info-col      { background: #f1f5f9; color: #1e3a8a; }

        table.kartu tbody td {
            padding: 5px 4px;
            border: 1px solid #e2e8f0;
            font-size: 9px;
            vertical-align: middle;
        }
        table.kartu tbody tr:nth-child(even) { background: #fafafa; }

        .row-saldo-awal td { background: #eff6ff; font-weight: bold; color: #1e40af; }
        .row-masuk  td { background: #f0fdf4; }
        .row-keluar td { background: #fff7f7; }
        .row-total  td {
            background: #f1f5f9;
            font-weight: bold;
            color: #1e3a8a;
            border-top: 2px solid #1e3a8a;
        }

        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .text-left   { text-align: left; }
        .fw-bold     { font-weight: bold; }
        .text-muted  { color: #94a3b8; }

        .badge-pembelian { background: #d1fae5; color: #065f46; padding: 1px 5px; border-radius: 4px; font-size: 7.5px; font-weight: bold; }
        .badge-penjualan { background: #fecaca; color: #991b1b; padding: 1px 5px; border-radius: 4px; font-size: 7.5px; font-weight: bold; }

        /* ── Footer ── */
        .footer {
            margin-top: 16px;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
            font-size: 8px;
            color: #64748b;
            text-align: center;
        }
        .note {
            font-size: 8px;
            color: #64748b;
            font-style: italic;
            margin-top: 8px;
        }

        /* ── TTD ── */
        .ttd-row {
            display: table;
            width: 100%;
            margin-top: 30px;
        }
        .ttd-cell {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            font-size: 9px;
        }
        .ttd-line {
            border-bottom: 1px solid #1e3a8a;
            width: 120px;
            margin: 40px auto 4px;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h1>RAYA-E</h1>
    <h2>KARTU STOK BARANG</h2>
</div>

<!-- Info Barang -->
<div class="info-box">
    <table class="info-table">
        <tr>
            <td class="label">Nama Barang</td>
            <td class="value">: <strong>{{ $kartuStok['barang']->nama_barang }}</strong></td>
            <td class="label">Periode</td>
            <td class="value">: {{ \Carbon\Carbon::parse($kartuStok['tanggal_dari'])->format('d/m/Y') }}
                s/d {{ \Carbon\Carbon::parse($kartuStok['tanggal_sampai'])->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Kode Barang</td>
            <td class="value">: {{ $kartuStok['barang']->kode_barang }}</td>
            <td class="label">Metode Penilaian</td>
            <td class="value">: <strong>FIFO (First-In, First-Out)</strong></td>
        </tr>
        <tr>
            <td class="label">Kategori / Merk</td>
            <td class="value">: {{ $kartuStok['barang']->kategori }} / {{ $kartuStok['barang']->merk }}</td>
            <td class="label">Tanggal Cetak</td>
            <td class="value">: {{ date('d/m/Y H:i') }} WIB</td>
        </tr>
    </table>
</div>

<!-- Summary -->
<div class="summary-row">
    <div class="summary-cell awal">
        <div class="summary-label">Saldo Awal</div>
        <div class="summary-value">{{ number_format($kartuStok['saldo_awal_qty']) }} Unit</div>
        <div class="summary-sub">Rp {{ number_format($kartuStok['saldo_awal_nilai'], 0, ',', '.') }}</div>
    </div>
    <div class="summary-cell pembelian">
        <div class="summary-label">Total Pembelian</div>
        <div class="summary-value" style="color:#065f46;">{{ number_format($kartuStok['total_masuk_qty']) }} Unit</div>
        <div class="summary-sub">Rp {{ number_format($kartuStok['total_masuk_nilai'], 0, ',', '.') }}</div>
    </div>
    <div class="summary-cell penjualan">
        <div class="summary-label">Total Penjualan</div>
        <div class="summary-value" style="color:#991b1b;">{{ number_format($kartuStok['total_keluar_qty']) }} Unit</div>
        <div class="summary-sub">Rp {{ number_format($kartuStok['total_keluar_nilai'], 0, ',', '.') }}</div>
    </div>
    <div class="summary-cell saldo">
        <div class="summary-label">Saldo Akhir</div>
        <div class="summary-value" style="color:#92400e;">{{ number_format($kartuStok['saldo_akhir_qty']) }} Unit</div>
        <div class="summary-sub">Rp {{ number_format($kartuStok['saldo_akhir_nilai'], 0, ',', '.') }}</div>
    </div>
</div>

<!-- Kartu Stok Table -->
<table class="kartu">
    <thead>
        <tr class="group-header">
            <th rowspan="2" style="width:10%">Tanggal</th>
            <th rowspan="2" style="width:26%">Keterangan</th>
            <th colspan="3" style="background:#16a34a;">PEMBELIAN</th>
            <th colspan="3" style="background:#dc2626;">PENJUALAN</th>
            <th colspan="3" style="background:#d97706;">SALDO</th>
        </tr>
        <tr class="sub-header">
            <th class="pembelian-col text-center"  style="width:4%">Qty</th>
            <th class="pembelian-col text-right"   style="width:8%">Harga/Unit</th>
            <th class="pembelian-col text-right"   style="width:9%">Jumlah (Rp)</th>
            <th class="penjualan-col text-center"  style="width:4%">Qty</th>
            <th class="penjualan-col text-right"   style="width:8%">Harga/Unit</th>
            <th class="penjualan-col text-right"   style="width:9%">Jumlah (Rp)</th>
            <th class="saldo-col text-center"      style="width:4%">Qty</th>
            <th class="saldo-col text-right"       style="width:8%">Harga/Unit</th>
            <th class="saldo-col text-right"       style="width:9%">Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <!-- Saldo Awal -->
        <tr class="row-saldo-awal">
            <td class="text-center">{{ \Carbon\Carbon::parse($kartuStok['tanggal_dari'])->format('d/m/Y') }}</td>
            <td class="fw-bold">SALDO AWAL</td>
            <td></td><td></td><td></td>
            <td></td><td></td><td></td>
            <td class="text-center fw-bold">{{ number_format($kartuStok['saldo_awal_qty']) }}</td>
            <td class="text-right fw-bold">
                @if($kartuStok['saldo_awal_qty'] > 0)
                    {{ number_format($kartuStok['saldo_awal_nilai'] / $kartuStok['saldo_awal_qty'], 0, ',', '.') }}
                @else
                    -
                @endif
            </td>
            <td class="text-right fw-bold">{{ number_format($kartuStok['saldo_awal_nilai'], 0, ',', '.') }}</td>
        </tr>

        @forelse($kartuStok['rows'] as $row)
        <tr class="row-{{ $row['tipe'] }}">
            <td class="text-center">{{ \Carbon\Carbon::parse($row['tanggal'])->format('d/m/Y') }}</td>
            <td>
                {{ $row['keterangan'] }}
                <span class="badge-{{ $row['tipe'] === 'masuk' ? 'pembelian' : 'penjualan' }}">
                    {{ $row['tipe'] === 'masuk' ? 'Pembelian' : 'Penjualan' }}
                </span>
            </td>

            @if($row['tipe'] === 'masuk')
                <td class="text-center fw-bold" style="color:#16a34a;">{{ number_format($row['qty']) }}</td>
                <td class="text-right">{{ number_format($row['harga'], 0, ',', '.') }}</td>
                <td class="text-right fw-bold">{{ number_format($row['nilai'], 0, ',', '.') }}</td>
                <td class="text-center text-muted">-</td>
                <td class="text-right text-muted">-</td>
                <td class="text-right text-muted">-</td>
            @else
                <td class="text-center text-muted">-</td>
                <td class="text-right text-muted">-</td>
                <td class="text-right text-muted">-</td>
                <td class="text-center fw-bold" style="color:#dc2626;">{{ number_format($row['qty']) }}</td>
                <td class="text-right">{{ number_format($row['harga'], 0, ',', '.') }}</td>
                <td class="text-right fw-bold">{{ number_format($row['nilai'], 0, ',', '.') }}</td>
            @endif

            <td class="text-center fw-bold">{{ number_format($row['saldo_qty']) }}</td>
            <td class="text-right">
                @if($row['saldo_qty'] > 0)
                    {{ number_format($row['harga_rata'], 0, ',', '.') }}
                @else
                    -
                @endif
            </td>
            <td class="text-right fw-bold">{{ number_format($row['saldo_nilai'], 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="11" class="text-center" style="padding:16px;color:#94a3b8;">
                Tidak ada mutasi dalam periode ini
            </td>
        </tr>
        @endforelse

        <!-- Total -->
        <tr class="row-total">
            <td colspan="2" class="text-right">TOTAL MUTASI PERIODE</td>
            <td class="text-center">{{ number_format($kartuStok['total_masuk_qty']) }}</td>
            <td></td>
            <td class="text-right">{{ number_format($kartuStok['total_masuk_nilai'], 0, ',', '.') }}</td>
            <td class="text-center">{{ number_format($kartuStok['total_keluar_qty']) }}</td>
            <td></td>
            <td class="text-right">{{ number_format($kartuStok['total_keluar_nilai'], 0, ',', '.') }}</td>
            <td class="text-center">{{ number_format($kartuStok['saldo_akhir_qty']) }}</td>
            <td></td>
            <td class="text-right">{{ number_format($kartuStok['saldo_akhir_nilai'], 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<p class="note">
    * Penilaian persediaan menggunakan metode <strong>First-In, First-Out (FIFO)</strong>.
    Harga/Unit pada kolom Penjualan adalah rata-rata HPP berdasarkan harga beli serial number yang terjual.
    Saldo nilai dihitung secara kumulatif: Saldo Awal + Pembelian − Penjualan.
</p>

<!-- Tanda Tangan -->
<div class="ttd-row">
    <div class="ttd-cell">
        <div>Dibuat oleh,</div>
        <div class="ttd-line"></div>
        <div>( ________________________ )</div>
        <div style="margin-top:2px;">Bagian Gudang</div>
    </div>
    <div class="ttd-cell">
        <div>Diperiksa oleh,</div>
        <div class="ttd-line"></div>
        <div>( ________________________ )</div>
        <div style="margin-top:2px;">Bagian Akuntansi</div>
    </div>
    <div class="ttd-cell">
        <div>Disetujui oleh,</div>
        <div class="ttd-line"></div>
        <div>( ________________________ )</div>
        <div style="margin-top:2px;">Pimpinan</div>
    </div>
</div>

<div class="footer">
    <p>Dokumen ini dicetak secara otomatis oleh sistem RAYA-E &nbsp;|&nbsp; {{ date('d F Y, H:i') }} WIB</p>
    <p>© {{ date('Y') }} RAYA-E. All rights reserved.</p>
</div>

</body>
</html>
