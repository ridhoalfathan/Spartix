<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Umum - {{ $startDate }} s/d {{ $endDate }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #000;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 20pt;
            margin-bottom: 5px;
            color: #1e40af;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 11pt;
            color: #666;
            margin-bottom: 3px;
        }

        .header .period {
            font-size: 10pt;
            color: #444;
            font-weight: bold;
        }

        .filter-info {
            background: #f3f4f6;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #1e40af;
        }

        .filter-info p {
            margin: 3px 0;
            font-size: 9pt;
        }

        .filter-info strong {
            color: #1e40af;
        }

        .summary-container {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .summary-row {
            display: table-row;
        }

        .summary-box {
            display: table-cell;
            width: 33.33%;
            padding: 12px;
            text-align: center;
            border: 2px solid #e5e7eb;
            background: #f9fafb;
        }

        .summary-box.debit {
            border-color: #10b981;
            background: #d1fae5;
        }

        .summary-box.kredit {
            border-color: #ef4444;
            background: #fee2e2;
        }

        .summary-box.saldo {
            border-color: #3b82f6;
            background: #dbeafe;
        }

        .summary-label {
            font-size: 8pt;
            color: #666;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 14pt;
            font-weight: bold;
        }

        .summary-box.debit .summary-value {
            color: #059669;
        }

        .summary-box.kredit .summary-value {
            color: #dc2626;
        }

        .summary-box.saldo .summary-value {
            color: #2563eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background: #1e40af;
            color: white;
        }

        th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 9pt;
            text-transform: uppercase;
            border: 1px solid #1e3a8a;
        }

        th.text-right {
            text-align: right;
        }

        td {
            padding: 8px;
            border: 1px solid #e5e7eb;
            font-size: 9pt;
        }

        td.text-right {
            text-align: right;
        }

        td.text-center {
            text-align: center;
        }

        tr.debit-row {
            background: #f0fdf4;
        }

        tr.kredit-row {
            background: #fef2f2;
            border-bottom: 2px solid #cbd5e1;
        }

        tr.debit-row:hover,
        tr.kredit-row:hover {
            background: #f3f4f6;
        }

        td.indent {
            padding-left: 30px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-auto {
            background: #d1fae5;
            color: #059669;
            border: 1px solid #10b981;
        }

        .badge-manual {
            background: #e9d5ff;
            color: #7c3aed;
            border: 1px solid #a78bfa;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            font-size: 8pt;
            color: #666;
        }

        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 10px;
        }

        .signature-box p {
            margin-bottom: 60px;
            font-size: 9pt;
            font-weight: bold;
        }

        .signature-name {
            border-top: 1px solid #000;
            padding-top: 5px;
            display: inline-block;
            min-width: 200px;
            font-size: 9pt;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
            font-style: italic;
        }

        .reference {
            font-size: 8pt;
            color: #6b7280;
            font-style: italic;
        }

        /* Print specific styles */
        @media print {
            body {
                padding: 0;
            }
            
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>JURNAL UMUM</h1>
        <div class="subtitle">Laporan Transaksi Keuangan</div>
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
    </div>

    @if($sumber && $sumber != 'semua')
    <div class="filter-info">
        <p><strong>Filter Sumber:</strong> 
            @if($sumber == 'pembelian')
                Pembelian
            @elseif($sumber == 'transaksi')
                Transaksi/Penjualan
            @elseif($sumber == 'salary_report')
                Gaji Karyawan
            @elseif($sumber == 'manual')
                Input Manual
            @endif
        </p>
    </div>
    @endif

    <div class="summary-container">
        <div class="summary-row">
            <div class="summary-box debit">
                <div class="summary-label">Total Debit</div>
                <div class="summary-value">Rp {{ number_format($totalDebit, 0, ',', '.') }}</div>
            </div>
            <div class="summary-box kredit">
                <div class="summary-label">Total Kredit</div>
                <div class="summary-value">Rp {{ number_format($totalKredit, 0, ',', '.') }}</div>
            </div>
            <div class="summary-box saldo">
                <div class="summary-label">Selisih</div>
                <div class="summary-value">Rp {{ number_format($totalDebit - $totalKredit, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 80px;">Tanggal</th>
                <th style="width: 70px;">Sumber</th>
                <th>Keterangan</th>
                <th style="width: 120px;">Akun</th>
                <th class="text-right" style="width: 100px;">Debit (Rp)</th>
                <th class="text-right" style="width: 100px;">Kredit (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $index => $jurnal)
            <!-- Baris Debit -->
            <tr class="debit-row">
                <td rowspan="2" class="text-center"><strong>{{ $index + 1 }}</strong></td>
                <td rowspan="2">{{ $jurnal->tanggal->format('d/m/Y') }}</td>
                <td rowspan="2" class="text-center">
                    @if($jurnal->isManual())
                        <span class="badge badge-manual">Manual</span>
                    @else
                        <span class="badge badge-auto">
                            @if($jurnal->sumber_transaksi == 'pembelian')
                                Pembelian
                            @elseif($jurnal->sumber_transaksi == 'transaksi')
                                Penjualan
                            @elseif($jurnal->sumber_transaksi == 'salary_report')
                                Gaji
                            @endif
                        </span>
                    @endif
                </td>
                <td rowspan="2">
                    {{ $jurnal->keterangan }}
                    @if($jurnal->no_referensi)
                        <br><span class="reference">Ref: {{ $jurnal->no_referensi }}</span>
                    @endif
                </td>
                <td><strong>{{ $jurnal->akun_debit }}</strong></td>
                <td class="text-right"><strong>{{ number_format($jurnal->debit, 0, ',', '.') }}</strong></td>
                <td class="text-right">-</td>
            </tr>
            <!-- Baris Kredit -->
            <tr class="kredit-row">
                <td class="indent"><strong>{{ $jurnal->akun_kredit }}</strong></td>
                <td class="text-right">-</td>
                <td class="text-right"><strong>{{ number_format($jurnal->kredit, 0, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-state">
                    Tidak ada data jurnal untuk periode yang dipilih
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($jurnals->count() > 0)
        <tfoot>
            <tr style="background: #f3f4f6; font-weight: bold;">
                <td colspan="5" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right" style="color: #059669;"><strong>{{ number_format($totalDebit, 0, ',', '.') }}</strong></td>
                <td class="text-right" style="color: #dc2626;"><strong>{{ number_format($totalKredit, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <p>Diperiksa Oleh,</p>
            <div class="signature-name">
                ( _________________ )
            </div>
        </div>
        <div class="signature-box">
            <p>Disetujui Oleh,</p>
            <div class="signature-name">
                ( _________________ )
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i:s') }}</p>
        <p>Sistem Informasi Akuntansi - Spartix Dashboard</p>
    </div>
</body>
</html>