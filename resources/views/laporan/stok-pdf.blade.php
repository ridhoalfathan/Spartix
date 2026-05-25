<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
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
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        table tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .badge {
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 9px;
            display: inline-block;
            text-transform: uppercase;
        }
        
        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .badge-danger {
            background: #fecaca;
            color: #991b1b;
        }
        
        .badge-category {
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 9px;
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
        
        .summary-box {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            display: table;
            width: 100%;
        }
        
        .summary-item {
            display: inline-block;
            margin-right: 40px;
        }
        
        .summary-label {
            font-size: 9px;
            color: #64748b;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #1e3a8a;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RAYA-E</h1>
        <h2>Laporan Stok Barang</h2>
    </div>
    
    <div class="info-box">
        <div class="info-item">
            <div class="info-label">Tanggal Cetak:</div>
            <div class="info-value">{{ date('d F Y, H:i') }} WIB</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total Item:</div>
            <div class="info-value">{{ $barang->count() }} Item</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total Stok:</div>
            <div class="info-value">{{ $barang->sum('stok') }} Unit</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total Nilai Persediaan:</div>
            <div class="info-value"><strong>Rp {{ number_format($barang->sum(function($b) { return $b->serialNumbers->sum('harga_beli'); }), 0, ',', '.') }}</strong></div>
        </div>
    </div>
    
    @if($barang->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 10%;">KODE</th>
                <th style="width: 25%;">NAMA BARANG</th>
                <th style="width: 10%;">KATEGORI</th>
                <th style="width: 12%;">MERK</th>
                <th style="width: 8%;">STOK</th>
                <th style="width: 10%;">METODE</th>
                <th style="width: 12%;">NILAI (FIFO)</th>
                <th style="width: 8%;">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td><strong>{{ $item->kode_barang }}</strong></td>
                <td>{{ $item->nama_barang }}</td>
                <td>
                    <span class="badge-category badge-{{ strtolower($item->kategori) }}">
                        {{ $item->kategori }}
                    </span>
                </td>
                <td>{{ $item->merk }}</td>
                <td style="text-align: center;"><strong>{{ $item->stok }}</strong></td>
                <td style="text-align: center;">FIFO</td>
                <td style="text-align: right;"><strong>Rp {{ number_format($item->serialNumbers->sum('harga_beli'), 0, ',', '.') }}</strong></td>
                <td>
                    @if($item->stok <= 0)
                        <span class="badge badge-danger">Habis</span>
                    @elseif($item->stok <= $item->stok_minimum)
                        <span class="badge badge-warning">Rendah</span>
                    @else
                        <span class="badge badge-success">Normal</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="summary-box">
        <div class="summary-item">
            <div class="summary-label">Stok Normal</div>
            <div class="summary-value" style="color: #22c55e;">
                {{ $barang->filter(function($item) { 
                    return $item->stok > $item->stok_minimum; 
                })->count() }}
            </div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Stok Rendah</div>
            <div class="summary-value" style="color: #f59e0b;">
                {{ $barang->filter(function($item) { 
                    return $item->stok <= $item->stok_minimum && $item->stok > 0; 
                })->count() }}
            </div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Stok Habis</div>
            <div class="summary-value" style="color: #ef4444;">
                {{ $barang->filter(function($item) { 
                    return $item->stok <= 0; 
                })->count() }}
            </div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Total Nilai Persediaan (FIFO)</div>
            <div class="summary-value" style="color: #ea580c;">
                Rp {{ number_format($barang->sum(function($b) { return $b->serialNumbers->sum('harga_beli'); }), 0, ',', '.') }}
            </div>
        </div>
    </div>
    @else
    <p style="text-align: center; color: #64748b; padding: 40px;">Tidak ada data barang.</p>
    @endif
    
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem RAYA-E</p>
        <p>© {{ date('Y') }} RAYA-E. All rights reserved.</p>
    </div>
</body>
</html>