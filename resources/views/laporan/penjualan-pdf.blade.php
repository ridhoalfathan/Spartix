<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 24px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0 0 0;
            color: #64748b;
            font-size: 16px;
            font-weight: normal;
        }
        
        .info-box {
            background: #f1f5f9;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: table;
            width: 100%;
        }
        
        .info-item {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #475569;
            padding: 5px 20px 5px 0;
            width: 150px;
        }
        
        .info-value {
            display: table-cell;
            color: #1e3a8a;
            padding: 5px 0;
        }
        
        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 10px;
        }
        
        .summary-card {
            display: table-cell;
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            width: 33.33%;
        }
        
        .summary-card.success {
            background: #d1fae5;
        }
        
        .summary-label {
            font-size: 9px;
            color: #64748b;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        
        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
        }
        
        .summary-value.success {
            color: #065f46;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background: #1e3a8a;
            color: white;
        }
        
        table thead th {
            padding: 10px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        table tbody td {
            padding: 8px 6px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9px;
        }
        
        table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .badge-category {
            padding: 3px 8px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 8px;
            display: inline-block;
        }
        
        .badge-tv {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .badge-ac {
            background: #ddd6fe;
            color: #5b21b6;
        }
        
        .badge-kulkas {
            background: #fce7f3;
            color: #9f1239;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
        
        .text-success {
            color: #22c55e;
            font-weight: bold;
        }
        
        .text-danger {
            color: #ef4444;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RAYA-E</h1>
        <h2>Laporan Penjualan</h2>
    </div>
    
    <div class="info-box">
        <div class="info-item">
            <div class="info-label">Tanggal Cetak:</div>
            <div class="info-value">{{ date('d F Y, H:i') }} WIB</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total Transaksi:</div>
            <div class="info-value">{{ $penjualan->count() }} Transaksi</div>
        </div>
        @if(request('tanggal_awal') && request('tanggal_akhir'))
        <div class="info-item">
            <div class="info-label">Periode:</div>
            <div class="info-value">
                {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }} - 
                {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}
            </div>
        </div>
        @endif
    </div>
    
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-label">Total HPP</div>
            <div class="summary-value">Rp {{ number_format($totalHPP, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Total Penjualan</div>
            <div class="summary-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card success">
            <div class="summary-label">Total Laba</div>
            <div class="summary-value success">Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
        </div>
    </div>
    
    @if($penjualan->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 10%;">TANGGAL</th>
                <th style="width: 14%;">NO. TRANS</th>
                <th style="width: 25%;">BARANG</th>
                <th style="width: 9%;">JUMLAH</th>
                <th style="width: 12%;">HPP</th>
                <th style="width: 13%;">HARGA JUAL</th>
                <th style="width: 13%;">LABA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                <td><strong>{{ $item->nomor_transaksi }}</strong></td>
                <td>
                    <strong>{{ $item->barang->nama_barang }}</strong><br>
                    <span style="color: #64748b; font-size: 8px;">{{ $item->barang->kode_barang }}</span>
                </td>
                <td style="text-align: center;">{{ $item->jumlah }} Unit</td>
                <td>Rp {{ number_format($item->hpp, 0, ',', '.') }}</td>
                <td><strong>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</strong></td>
                <td class="{{ $item->laba >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $item->laba >= 0 ? '+' : '' }}Rp {{ number_format($item->laba, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="background: #f1f5f9; padding: 15px; border-radius: 8px;">
        <table style="width: auto; float: right; margin: 0;">
            <tr>
                <td style="border: none; padding: 5px 15px; text-align: right; font-weight: bold;">Total HPP:</td>
                <td style="border: none; padding: 5px 0; font-weight: bold; color: #1e3a8a;">Rp {{ number_format($totalHPP, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 5px 15px; text-align: right; font-weight: bold;">Total Penjualan:</td>
                <td style="border: none; padding: 5px 0; font-weight: bold; color: #1e3a8a;">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top: 2px solid #1e3a8a;">
                <td style="border: none; padding: 8px 15px; text-align: right; font-weight: bold; font-size: 11px;">TOTAL LABA:</td>
                <td style="border: none; padding: 8px 0; font-weight: bold; color: #22c55e; font-size: 11px;">Rp {{ number_format($totalLaba, 0, ',', '.') }}</td>
            </tr>
        </table>
        <div style="clear: both;"></div>
    </div>
    @else
    <p style="text-align: center; color: #64748b; padding: 40px;">Tidak ada data penjualan.</p>
    @endif
    
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem RAYA-E</p>
        <p>© {{ date('Y') }} RAYA-E. All rights reserved.</p>
    </div>
</body>
</html>