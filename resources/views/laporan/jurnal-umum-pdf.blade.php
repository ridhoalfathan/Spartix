<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Jurnal Umum</title>
    <style>
        @page {
            size: A4;
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
        
        .jurnal-entry {
            margin-bottom: 20px;
            border: 2px solid #2563EB;
            border-radius: 8px;
            page-break-inside: avoid;
            overflow: hidden;
        }
        
        .jurnal-header {
            background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            padding: 10px 12px;
            color: white;
            font-weight: bold;
            font-size: 11px;
            display: flex;
            justify-content: space-between;
        }
        
        .jurnal-header-left {
            flex: 1;
        }
        
        .jurnal-header-right {
            text-align: right;
            font-size: 10px;
        }
        
        table.jurnal-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        
        table.jurnal-table th,
        table.jurnal-table td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            vertical-align: top;
        }
        
        table.jurnal-table th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: #1e3a8a;
            font-weight: 800;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #2563EB;
        }
        
        table.jurnal-table th.text-right {
            text-align: right;
        }
        
        table.jurnal-table tbody tr {
            background: white;
        }
        
        table.jurnal-table tbody tr:nth-child(even) {
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
        
        .akun-kredit {
            padding-left: 30px;
            display: inline-block;
        }
        
        .kode-akun {
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
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
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
        <h2>Laporan Jurnal Umum</h2>
        <h3>RAYA-E - Sistem Persediaan Elektronik</h3>
        @if(isset($tanggalDari) && isset($tanggalSampai))
        <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggalDari)->format('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalSampai)->format('d F Y') }}</p>
        @else
        <p><strong>Periode:</strong> Semua Transaksi</p>
        @endif
        <p><strong>Dicetak:</strong> {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d F Y, H:i:s') }} WIB</p>
    </div>

    <!-- Summary Section -->
    <div class="summary">
        <table>
            <tr>
                <td width="33%">
                    <div class="summary-label">Total Jurnal</div>
                    <div class="summary-value">{{ $jurnalEntries->count() }} transaksi</div>
                </td>
                <td width="33%">
                    <div class="summary-label">Total Debit</div>
                    <div class="summary-value">Rp {{ number_format($jurnalEntries->sum('total_debit'), 0, ',', '.') }}</div>
                </td>
                <td width="34%">
                    <div class="summary-label">Total Kredit</div>
                    <div class="summary-value">Rp {{ number_format($jurnalEntries->sum('total_kredit'), 0, ',', '.') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Jurnal Entries -->
    @forelse($jurnalEntries as $jurnal)
    <div class="jurnal-entry">
        <div class="jurnal-header">
            <div class="jurnal-header-left">
                <strong>{{ $jurnal->no_jurnal }}</strong> | {{ $jurnal->tanggal->format('d F Y') }}
            </div>
            <div class="jurnal-header-right">
                <span class="badge">👤 {{ $jurnal->user->name }}</span>
            </div>
        </div>
        <table class="jurnal-table">
            <thead>
                <tr>
                    <th width="10%">Kode</th>
                    <th width="25%">Nama Akun</th>
                    <th width="40%">Keterangan</th>
                    <th width="12.5%" class="text-right">Debit</th>
                    <th width="12.5%" class="text-right">Kredit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jurnal->details as $detail)
                <tr>
                    <td>
                        @if($detail->debit > 0)
                        <span class="kode-akun">{{ $detail->akun->kode_akun }}</span>
                        @endif
                    </td>
                    <td>
                        @if($detail->debit > 0)
                        <span class="nama-akun">{{ $detail->akun->nama_akun }}</span>
                        @else
                        <span class="akun-kredit">
                            <span class="nama-akun">{{ $detail->akun->nama_akun }}</span>
                        </span>
                        @endif
                    </td>
                    <td>
                        <span class="keterangan-text">{{ $detail->keterangan ?? $jurnal->keterangan ?? '-' }}</span>
                    </td>
                    <td class="text-right">
                        @if($detail->debit > 0)
                        <span class="debit-value">Rp {{ number_format($detail->debit, 0, ',', '.') }}</span>
                        @else
                        <span class="null-value">-</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if($detail->kredit > 0)
                        <span class="kredit-value">Rp {{ number_format($detail->kredit, 0, ',', '.') }}</span>
                        @else
                        <span class="null-value">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" class="text-right"><strong>TOTAL</strong></td>
                    <td class="text-right">
                        <span class="debit-value">Rp {{ number_format($jurnal->total_debit, 0, ',', '.') }}</span>
                    </td>
                    <td class="text-right">
                        <span class="kredit-value">Rp {{ number_format($jurnal->total_kredit, 0, ',', '.') }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @empty
    <div class="no-data">
        <div class="no-data-icon">📭</div>
        <h4>Tidak Ada Data</h4>
        <p>Tidak ada data jurnal umum untuk periode yang dipilih</p>
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

