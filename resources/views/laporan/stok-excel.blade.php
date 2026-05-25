<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Barang - RAYA-E</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #1e3a8a;
        }
        .header p {
            margin: 5px 0;
            color: #475569;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            border: 1px solid #cbd5e1;
            padding: 10px;
            text-align: left;
        }
        td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .fw-bold {
            font-weight: bold;
        }
        .bg-gray {
            background-color: #f1f5f9;
        }
        .badge-normal {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-danger {
            background-color: #fecaca;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>RAYA-E</h2>
        <h3>LAPORAN STOK BARANG</h3>
        <p>Tanggal Ekspor: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>KODE</th>
                <th>NAMA BARANG</th>
                <th>KATEGORI</th>
                <th>MERK</th>
                <th>STOK (UNIT)</th>
                <th>METODE</th>
                <th>NILAI PERSEDIAAN (FIFO)</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="fw-bold">{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->merk }}</td>
                <td class="text-center fw-bold">{{ $item->stok }}</td>
                <td class="text-center">FIFO</td>
                <td class="text-right">Rp {{ number_format($item->serialNumbers->sum('harga_beli'), 0, ',', '.') }}</td>
                <td class="text-center fw-bold">
                    @if($item->stok <= 0)
                        Habis
                    @elseif($item->stok <= $item->stok_minimum)
                        Rendah
                    @else
                        Normal
                    @endif
                </td>
            </tr>
            @endforeach
            <tr class="bg-gray fw-bold">
                <td colspan="5" class="text-right">TOTAL</td>
                <td class="text-center">{{ $barang->sum('stok') }}</td>
                <td class="text-center">-</td>
                <td class="text-right">Rp {{ number_format($barang->sum(function($b) { return $b->serialNumbers->sum('harga_beli'); }), 0, ',', '.') }}</td>
                <td class="text-center">-</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 25px;">
        <p><strong>Ringkasan Laporan:</strong></p>
        <ul>
            <li>Total Kategori Barang: {{ $barang->pluck('kategori')->unique()->count() }}</li>
            <li>Total Item Terdaftar: {{ $barang->count() }}</li>
            <li>Total Fisik Unit Stok: {{ $barang->sum('stok') }} Unit</li>
            <li>Total Nilai Aset Persediaan (FIFO): Rp {{ number_format($barang->sum(function($b) { return $b->serialNumbers->sum('harga_beli'); }), 0, ',', '.') }}</li>
        </ul>
    </div>
</body>
</html>
