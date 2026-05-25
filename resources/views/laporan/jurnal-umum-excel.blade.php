<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Jurnal Umum - Akuntansi - RAYA-E</title>
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
            background-color: #2563eb;
            color: #ffffff;
            font-weight: bold;
            border: 1px solid #cbd5e1;
            padding: 10px;
            text-align: center;
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
            background-color: #f8fafc;
        }
        .bg-total {
            background-color: #f1f5f9;
        }
        .indent-kredit {
            padding-left: 25px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>RAYA-E</h2>
        <h3>LAPORAN JURNAL UMUM</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($tanggalSampai)->format('d/m/Y') }}</p>
        <p>Tanggal Ekspor: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>TANGGAL</th>
                <th>NOMOR JURNAL</th>
                <th>KODE AKUN</th>
                <th>NAMA REKENING / AKUN</th>
                <th>DEBIT (Rp)</th>
                <th>KREDIT (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalDebit = 0;
                $totalKredit = 0;
            @endphp
            @forelse($jurnalEntries as $jurnal)
                @php
                    $totalDebit += $jurnal->details->sum('debit');
                    $totalKredit += $jurnal->details->sum('kredit');
                @endphp
                @foreach($jurnal->details as $index => $detail)
                <tr>
                    <td class="text-center">
                        @if($index === 0)
                            {{ $jurnal->tanggal->format('d/m/Y') }}
                        @endif
                    </td>
                    <td class="text-center fw-bold">
                        @if($index === 0)
                            {{ $jurnal->no_jurnal }}
                        @endif
                    </td>
                    <td>{{ $detail->akun->kode_akun }}</td>
                    <td style="{{ $detail->kredit > 0 ? 'padding-left: 30px;' : '' }}">
                        @if($detail->kredit > 0)
                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $detail->akun->nama_akun }}
                        @else
                            {{ $detail->akun->nama_akun }}
                        @endif
                    </td>
                    <td class="text-right">
                        @if($detail->debit > 0)
                            Rp {{ number_format($detail->debit, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        @if($detail->kredit > 0)
                            Rp {{ number_format($detail->kredit, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
                <!-- Empty spacer row for readability inside Excel -->
                <tr style="height: 10px; background-color: #fdfdfd;">
                    <td colspan="6" style="border-left: 1px solid #cbd5e1; border-right: 1px solid #cbd5e1; border-top: none; border-bottom: none; padding: 0;"></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Belum ada data jurnal untuk periode ini.</td>
                </tr>
            @endforelse
            
            @if($jurnalEntries->count() > 0)
            <tr class="bg-total fw-bold">
                <td colspan="4" class="text-right fw-bold">TOTAL KESELURUHAN JURNAL</td>
                <td class="text-right fw-bold" style="color: #10b981;">Rp {{ number_format($totalDebit, 0, ',', '.') }}</td>
                <td class="text-right fw-bold" style="color: #ef4444;">Rp {{ number_format($totalKredit, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 25px;">
        <p><strong>Status Jurnal:</strong></p>
        <ul>
            <li>Jumlah Entri Transaksi: {{ $jurnalEntries->count() }} Jurnal</li>
            <li>Status Keseimbangan (Balancing): <strong>{{ $totalDebit === $totalKredit ? 'SEIMBANG (BALANCED)' : 'TIDAK SEIMBANG' }}</strong></li>
        </ul>
        <p style="font-size: 0.85rem; color: #64748b; font-style: italic;">
            * Dicetak secara otomatis oleh sistem akuntansi RAYA-E sesuai dengan standar pencatatan akuntansi berpasangan (double-entry bookkeeping).
        </p>
    </div>
</body>
</html>


