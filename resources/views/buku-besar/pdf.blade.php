<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Buku Besar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #1e3a8a;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 11px;
            color: #666;
            margin: 3px 0;
        }

        .period-info {
            background: #f1f5f9;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2563eb;
        }

        .period-info strong {
            color: #1e3a8a;
        }

        .account-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .account-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            padding: 10px 15px;
            border-radius: 8px 8px 0 0;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table thead {
            background: #1e3a8a;
            color: white;
        }

        table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            border: 1px solid #1e40af;
        }

        table th.text-right {
            text-align: right;
        }

        table tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }

        table tbody tr:hover {
            background: #f8fafc;
        }

        table td {
            padding: 8px;
            font-size: 10px;
            border: 1px solid #e2e8f0;
        }

        table td.text-right {
            text-align: right;
        }

        .saldo-awal-row {
            background: #fef3c7 !important;
            font-weight: bold;
        }

        .saldo-awal-row td {
            color: #92400e;
            border-bottom: 2px solid #fbbf24;
        }

        .total-row {
            background: #dbeafe !important;
            font-weight: bold;
            font-size: 11px;
        }

        .total-row td {
            color: #1e3a8a;
            border-top: 2px solid #2563eb;
            border-bottom: 2px solid #2563eb;
            padding: 10px 8px;
        }

        .debit-amount {
            color: #059669;
            font-weight: 600;
        }

        .kredit-amount {
            color: #dc2626;
            font-weight: 600;
        }

        .saldo-amount {
            color: #1e40af;
            font-weight: bold;
            background: #eff6ff;
        }

        .summary-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .summary-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #2563eb;
        }

        .summary-grid {
            display: table;
            width: 100%;
            margin-top: 10px;
        }

        .summary-row {
            display: table-row;
        }

        .summary-card {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            text-align: center;
            border: 2px solid #e2e8f0;
            vertical-align: middle;
        }

        .summary-card.kas {
            border-color: #10b981;
            background: #ecfdf5;
        }

        .summary-card.pendapatan {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .summary-card.beban {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .summary-card h6 {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .summary-card.kas h6 {
            color: #059669;
        }

        .summary-card.pendapatan h6 {
            color: #1d4ed8;
        }

        .summary-card.beban h6 {
            color: #dc2626;
        }

        .summary-card h4 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .summary-card.kas h4 {
            color: #10b981;
        }

        .summary-card.pendapatan h4 {
            color: #2563eb;
        }

        .summary-card.beban h4 {
            color: #ef4444;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .page-break {
            page-break-after: always;
        }

        @page {
            margin: 15mm;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🏢 PT. SPARTIX</h1>
        <h2>📚 BUKU BESAR</h2>
        <p>Laporan Transaksi Per Akun</p>
    </div>

    <!-- Period Info -->
    <div class="period-info">
        <strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        @if($akunFilter)
            | <strong>Akun:</strong> {{ $akunFilter }}
        @else
            | <strong>Filter:</strong> Semua Akun
        @endif
    </div>

    @if($bukuBesarGrouped->isEmpty())
        <div style="text-align: center; padding: 40px; color: #ef4444; font-weight: bold;">
            ⚠️ Tidak ada data buku besar untuk periode ini
        </div>
    @else
        <!-- Loop per Akun -->
        @foreach($bukuBesarGrouped as $namaAkun => $items)
            <div class="account-section">
                <div class="account-header">
                    @if(stripos($namaAkun, 'Kas') !== false || stripos($namaAkun, 'Bank') !== false)
                        💰 Buku Besar - {{ $namaAkun }}
                    @elseif(stripos($namaAkun, 'Pendapatan') !== false)
                        💵 Buku Besar - {{ $namaAkun }}
                    @elseif(stripos($namaAkun, 'Beban') !== false)
                        💸 Buku Besar - {{ $namaAkun }}
                    @elseif(stripos($namaAkun, 'Modal') !== false)
                        💎 Buku Besar - {{ $namaAkun }}
                    @elseif(stripos($namaAkun, 'Hutang') !== false || stripos($namaAkun, 'Utang') !== false)
                        📋 Buku Besar - {{ $namaAkun }}
                    @elseif(stripos($namaAkun, 'Piutang') !== false)
                        📄 Buku Besar - {{ $namaAkun }}
                    @else
                        📊 Buku Besar - {{ $namaAkun }}
                    @endif
                </div>

                <table>
                    <thead>
                        <tr>
                            <th width="12%">Tanggal</th>
                            <th width="35%">Keterangan</th>
                            <th width="10%">No. Ref</th>
                            <th width="14%" class="text-right">Debit</th>
                            <th width="14%" class="text-right">Kredit</th>
                            <th width="15%" class="text-right">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Saldo Awal -->
                        @if(isset($saldoAwal[$namaAkun]) && $saldoAwal[$namaAkun] != 0)
                            <tr class="saldo-awal-row">
                                <td colspan="3"><strong>Saldo Awal</strong></td>
                                <td class="text-right">-</td>
                                <td class="text-right">-</td>
                                <td class="text-right"><strong>Rp {{ number_format($saldoAwal[$namaAkun], 0, ',', '.') }}</strong></td>
                            </tr>
                        @endif

                        <!-- Data Transaksi -->
                        @foreach($items as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td style="text-align: center;">{{ $item->no_referensi ?? '-' }}</td>
                                <td class="text-right">
                                    @if($item->debit > 0)
                                        <span class="debit-amount">Rp {{ number_format($item->debit, 0, ',', '.') }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($item->kredit > 0)
                                        <span class="kredit-amount">Rp {{ number_format($item->kredit, 0, ',', '.') }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right saldo-amount">
                                    <strong>Rp {{ number_format($item->saldo, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Total -->
                        <tr class="total-row">
                            <td colspan="3" class="text-right"><strong>TOTAL</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($items->sum('debit'), 0, ',', '.') }}</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($items->sum('kredit'), 0, ',', '.') }}</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($items->last()->saldo, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if(!$loop->last)
                <div style="margin-bottom: 20px;"></div>
            @endif
        @endforeach

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-title">📊 RINGKASAN SALDO AKHIR</div>
            
            <table style="border: none;">
                <tbody>
                    @foreach($bukuBesarGrouped->chunk(3) as $chunk)
                        <tr>
                            @foreach($chunk as $namaAkun => $items)
                                @php
                                    $saldoAkhir = $items->last()->saldo ?? 0;
                                    $cardClass = 'aset';
                                    $icon = '📊';
                                    
                                    if (stripos($namaAkun, 'Kas') !== false || stripos($namaAkun, 'Bank') !== false) {
                                        $cardClass = 'kas';
                                        $icon = '💰';
                                    } elseif (stripos($namaAkun, 'Pendapatan') !== false) {
                                        $cardClass = 'pendapatan';
                                        $icon = '💵';
                                    } elseif (stripos($namaAkun, 'Beban') !== false) {
                                        $cardClass = 'beban';
                                        $icon = '💸';
                                    } elseif (stripos($namaAkun, 'Modal') !== false) {
                                        $cardClass = 'modal';
                                        $icon = '💎';
                                    } elseif (stripos($namaAkun, 'Hutang') !== false || stripos($namaAkun, 'Utang') !== false) {
                                        $cardClass = 'hutang';
                                        $icon = '📋';
                                    }
                                @endphp
                                
                                <td class="summary-card {{ $cardClass }}" style="border: 2px solid 
                                    @if($cardClass == 'kas') #10b981
                                    @elseif($cardClass == 'pendapatan') #2563eb
                                    @elseif($cardClass == 'beban') #ef4444
                                    @elseif($cardClass == 'modal') #8b5cf6
                                    @elseif($cardClass == 'hutang') #f59e0b
                                    @else #06b6d4
                                    @endif;">
                                    <h6>{{ $icon }} {{ $namaAkun }}</h6>
                                    <h4>Rp {{ number_format(abs($saldoAkhir), 0, ',', '.') }}</h4>
                                </td>
                            @endforeach
                            
                            @for($i = $chunk->count(); $i < 3; $i++)
                                <td style="border: none;"></td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>
        <p>PT. SPARTIX - Sistem Akuntansi Terintegrasi</p>
    </div>
</body>
</html>