<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku Besar</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            color: #1e3a8a;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #2563EB;
            padding-bottom: 15px;
            background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        }
        
        .header h2 {
            margin: 0 0 8px 0;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1e3a8a;
            letter-spacing: 1px;
        }
        
        .header h3 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: 600;
            color: #2563EB;
        }
        
        .header p {
            margin: 3px 0;
            font-size: 10px;
            color: #64748b;
        }
        
        .summary {
            margin-bottom: 20px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            padding: 12px;
            border: 2px solid #2563EB;
            border-radius: 8px;
        }
        
        .summary table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .summary td {
            padding: 6px;
            font-size: 10px;
            font-weight: bold;
            color: #1e3a8a;
        }
        
        .summary-label {
            color: #64748b;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .summary-value {
            color: #1e3a8a;
            font-weight: 800;
            font-size: 11px;
        }
        
        .akun-entry {
            margin-bottom: 20px;
            border: 2px solid #2563EB;
            border-radius: 8px;
            page-break-inside: avoid;
            overflow: hidden;
        }
        
        .akun-header {
            background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            padding: 10px 12px;
            color: white;
            font-weight: bold;
            font-size: 11px;
            display: flex;
            justify-content: space-between;
        }
        
        .akun-header-left {
            flex: 1;
        }
        
        .akun-header-right {
            text-align: right;
            font-size: 10px;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            font-size: 9px;
            margin-left: 8px;
        }
        
        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        
        table.detail-table th,
        table.detail-table td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            vertical-align: top;
        }
        
        table.detail-table th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: #1e3a8a;
            font-weight: 800;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #2563EB;
        }
        
        table.detail-table th.text-right {
            text-align: right;
        }
        
        table.detail-table tbody tr {
            background: white;
        }
        
        table.detail-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .total-row {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
            font-weight: 800;
            border-top: 2px solid #2563EB !important;
        }
        
        .saldo-awal-row {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.15) 0%, rgba(2, 132, 199, 0.15) 100%) !important;
            font-weight: 800;
        }
        
        .kode-cell {
            color: #2563EB;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }
        
        .nama-akun {
            color: #1e3a8a;
            font-weight: 700;
        }
        
        .keterangan-text {
            color: #64748b;
            font-style: italic;
        }
        
        .debit-value {
            color: #10b981;
            font-weight: bold;
            font-family: 'Arial', sans-serif;
        }
        
        .kredit-value {
            color: #ef4444;
            font-weight: bold;
            font-family: 'Arial', sans-serif;
        }
        
        .saldo-value {
            color: #1e3a8a;
            font-weight: 800;
        }
        
        .null-value {
            color: #cbd5e1;
            text-align: center;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #2563EB;
        }
        
        .footer-grid {
            display: table;
            width: 100%;
        }
        
        .footer-left {
            display: table-cell;
            text-align: left;
            font-size: 9px;
            color: #64748b;
        }
        
        .footer-right {
            display: table-cell;
            text-align: right;
            font-size: 9px;
            color: #64748b;
        }
        
        .footer-signature {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #1e3a8a;
            padding-top: 5px;
            font-weight: bold;
            color: #1e3a8a;
        }
        
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }
        
        .no-data-icon {
            font-size: 48px;
            color: #cbd5e1;
            margin-bottom: 15px;
        }
        
        .no-data h4 {
            color: #1e3a8a;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .no-data p {
            font-size: 11px;
            font-style: italic;
        }
        
        /* Print optimization */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h2>Laporan Buku Besar</h2>
        <h3>RAYA-E - Sistem Persediaan Elektronik</h3>
        @if(isset($tanggalDari) && isset($tanggalSampai))
        <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggalDari)->format('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalSampai)->format('d F Y') }}</p>
        @else
        <p><strong>Periode:</strong> Semua Transaksi</p>
        @endif
        <p><strong>Dicetak:</strong> {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d F Y, H:i:s') }} WIB</p>
    </div>

    <!-- Summary Section -->
    @if(is_array($bukuBesar) && count($bukuBesar) > 0)
    <div class="summary">
        <table>
            <tr>
                <td width="33%">
                    <div class="summary-label">Total Akun</div>
                    <div class="summary-value">{{ count($bukuBesar) }} akun</div>
                </td>
                <td width="33%">
                    <div class="summary-label">Filter Tipe</div>
                    <div class="summary-value">{{ request('tipe_akun') ?? 'Semua Tipe' }}</div>
                </td>
                <td width="34%">
                    <div class="summary-label">Status</div>
                    <div class="summary-value">Buku Besar</div>
                </td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Akun Entries -->
    @forelse($bukuBesar as $item)
    <div class="akun-entry">
        <div class="akun-header">
            <div class="akun-header-left">
                <strong>{{ $item['akun']->nama_akun }}</strong>
                <span class="badge">{{ $item['akun']->tipe_akun }}</span>
            </div>
            <div class="akun-header-right">
                <strong>Kode: {{ $item['akun']->kode_akun }}</strong>
                <span class="badge">{{ $item['akun']->posisi_normal }}</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="detail-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Tanggal</th>
                        <th style="width: 35%;">Keterangan</th>
                        <th style="width: 6%;">Ref</th>
                        <th style="width: 12%;" class="text-right">Debit</th>
                        <th style="width: 12%;" class="text-right">Kredit</th>
                        <th style="width: 12.5%;" class="text-right">Saldo Debit</th>
                        <th style="width: 12.5%;" class="text-right">Saldo Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $saldoDebit = 0;
                        $saldoKredit = 0;
                        
                        // Saldo awal
                        if(isset($item['saldo_awal'])) {
                            if($item['akun']->posisi_normal == 'Debit') {
                                $saldoDebit = $item['saldo_awal'] >= 0 ? $item['saldo_awal'] : 0;
                                $saldoKredit = $item['saldo_awal'] < 0 ? abs($item['saldo_awal']) : 0;
                            } else {
                                $saldoKredit = $item['saldo_awal'] >= 0 ? $item['saldo_awal'] : 0;
                                $saldoDebit = $item['saldo_awal'] < 0 ? abs($item['saldo_awal']) : 0;
                            }
                        }
                    @endphp
                    
                    <tr class="saldo-awal-row">
                        <td class="text-center">
                            {{ isset($tanggalDari) ? \Carbon\Carbon::parse($tanggalDari)->format('M Y') : \Carbon\Carbon::now()->format('M Y') }}
                        </td>
                        <td colspan="4"><strong>SALDO AWAL</strong></td>
                        <td class="text-right">
                            @if($saldoDebit > 0)
                            <span class="saldo-value">Rp {{ number_format($saldoDebit, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td class="text-right">
                            @if($saldoKredit > 0)
                            <span class="saldo-value">Rp {{ number_format($saldoKredit, 0, ',', '.') }}</span>
                            @endif
                        </td>
                    </tr>

                    <!-- Transaksi -->
                    @if(isset($item['transaksi']) && count($item['transaksi']) > 0)
                        @foreach($item['transaksi'] as $transaksi)
                        @php
                            // Update saldo
                            if($item['akun']->posisi_normal == 'Debit') {
                                $saldoDebit += $transaksi->debit;
                                $saldoKredit += $transaksi->kredit;
                            } else {
                                $saldoKredit += $transaksi->kredit;
                                $saldoDebit += $transaksi->debit;
                            }
                            
                            // Hitung saldo bersih
                            $saldoBersih = $saldoDebit - $saldoKredit;
                            $tampilSaldoDebit = $saldoBersih > 0 ? $saldoBersih : 0;
                            $tampilSaldoKredit = $saldoBersih < 0 ? abs($saldoBersih) : 0;
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}
                            </td>
                            <td>
                                <span class="keterangan-text">{{ $transaksi->keterangan ?? '-' }}</span>
                            </td>
                            <td class="text-center">{{ $transaksi->ref ?? '' }}</td>
                            <td class="text-right">
                                @if($transaksi->debit > 0)
                                <span class="debit-value">
                                    Rp {{ number_format($transaksi->debit, 0, ',', '.') }}
                                </span>
                                @else
                                <span class="null-value">-</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($transaksi->kredit > 0)
                                <span class="kredit-value">
                                    Rp {{ number_format($transaksi->kredit, 0, ',', '.') }}
                                </span>
                                @else
                                <span class="null-value">-</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($tampilSaldoDebit > 0)
                                <strong>Rp {{ number_format($tampilSaldoDebit, 0, ',', '.') }}</strong>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($tampilSaldoKredit > 0)
                                <strong>Rp {{ number_format($tampilSaldoKredit, 0, ',', '.') }}</strong>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="no-data">
        <div class="no-data-icon">📭</div>
        <h4>Tidak Ada Data</h4>
        <p>Belum ada data buku besar yang tersedia untuk periode ini</p>
    </div>
    @endforelse

    <!-- Footer -->
    <div class="footer">
        <div class="footer-grid">
            <div class="footer-left">
                <p><strong>RAYA-E</strong> - Sistem Persediaan Elektronik</p>
                <p>Dokumen ini dicetak secara otomatis oleh sistem</p>
            </div>
            <div class="footer-right">
                <p>Halaman 1 dari 1</p>
                <p>{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>
        
        <div class="footer-signature">
            <div class="signature-box">
                <p style="margin: 0; font-size: 10px; color: #64748b;">Mengetahui,</p>
                <div class="signature-line">
                    {{ Auth::user()->name }}
                </div>
                <p style="margin: 5px 0 0 0; font-size: 9px; color: #64748b;">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>
</body>
</html>

