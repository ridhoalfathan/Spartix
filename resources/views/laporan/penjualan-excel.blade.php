<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan - RAYA-E</title>
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
            color: #16a34a;
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
            background-color: #16a34a;
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
    </style>
</head>
<body>
    <div class="header">
        <h2>RAYA-E</h2>
        <h3>LAPORAN PENJUALAN BARANG</h3>
        <p>Tanggal Ekspor: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>TANGGAL</th>
                <th>NO TRANSAKSI</th>
                <th>KODE BARANG</th>
                <th>NAMA BARANG</th>
                <th>JUMLAH (UNIT)</th>
                <th>HPP (FIFO)</th>
                <th>HARGA JUAL</th>
                <th>LABA / RUGI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                <td class="fw-bold">{{ $item->nomor_transaksi }}</td>
                <td>{{ $item->barang->kode_barang }}</td>
                <td class="fw-bold">{{ $item->barang->nama_barang }}</td>
                <td class="text-center">{{ $item->jumlah }}</td>
                <td class="text-right">Rp {{ number_format($item->hpp, 0, ',', '.') }}</td>
                <td class="text-right fw-bold">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                <td class="text-right fw-bold" style="color: {{ $item->laba >= 0 ? '#16a34a' : '#ef4444' }};">
                    {{ $item->laba >= 0 ? '+' : '' }}Rp {{ number_format($item->laba, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
            <tr class="bg-gray fw-bold">
                <td colspan="5" class="text-right">TOTAL</td>
                <td class="text-center">{{ $penjualan->sum('jumlah') }}</td>
                <td class="text-right">Rp {{ number_format($totalHPP, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                <td class="text-right" style="color: {{ $totalLaba >= 0 ? '#16a34a' : '#ef4444' }};">
                    Rp {{ number_format($totalLaba, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 25px;">
        <p><strong>Ringkasan Akuntansi Penjualan (Metode Penilaian FIFO):</strong></p>
        <ul>
            <li>Total Kuantitas Terjual: {{ $penjualan->sum('jumlah') }} Unit</li>
            <li>Total Beban Pokok Penjualan (HPP): Rp {{ number_format($totalHPP, 0, ',', '.') }}</li>
            <li>Total Pendapatan Penjualan Bersih: Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</li>
            <li>Total Laba Kotor Penjualan: Rp {{ number_format($totalLaba, 0, ',', '.') }}</li>
        </ul>
        <p style="font-size: 0.85rem; color: #64748b; font-style: italic;">
            * Seluruh perhitungan harga pokok dan laba otomatis disinkronisasikan menggunakan metode FIFO berdasarkan urutan serial number yang terjual.
        </p>
    </div>
</body>
</html>
