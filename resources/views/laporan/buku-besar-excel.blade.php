<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Buku Besar - RAYA-E</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h2 {
            margin: 0;
            color: #1e3a8a;
        }
        .header p {
            margin: 5px 0;
            color: #475569;
        }
        .account-box {
            background-color: #2563eb;
            color: #ffffff;
            font-weight: bold;
            padding: 8px 15px;
            margin-top: 30px;
            margin-bottom: 5px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 25px;
        }
        th {
            background-color: #f8fafc;
            color: #1e3a8a;
            font-weight: bold;
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: center;
            font-size: 0.85rem;
        }
        td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            vertical-align: middle;
            font-size: 0.85rem;
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
        .bg-info {
            background-color: #e0f2fe;
        }
        .bg-total {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>RAYA-E</h2>
        <h3>LAPORAN BUKU BESAR</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($tanggalSampai)->format('d/m/Y') }}</p>
        <p>Tanggal Ekspor: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    @forelse($bukuBesar as $item)
        <div class="account-box">
            KODE AKUN: {{ $item['akun']->kode_akun }} &nbsp;&nbsp;|&nbsp;&nbsp; NAMA AKUN: {{ $item['akun']->nama_akun }} &nbsp;&nbsp;|&nbsp;&nbsp; TIPE AKUN: {{ $item['akun']->tipe_akun }}
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" style="width: 12%;">TANGGAL</th>
                    <th rowspan="2" style="width: 30%;">KETERANGAN</th>
                    <th rowspan="2" style="width: 10%;">REF / NO JURNAL</th>
                    <th rowspan="2" style="width: 12%;">DEBIT (Rp)</th>
                    <th rowspan="2" style="width: 12%;">KREDIT (Rp)</th>
                    <th colspan="2" style="width: 24%;">SALDO AKUMULASI (Rp)</th>
                </tr>
                <tr>
                    <th>DEBIT</th>
                    <th>KREDIT</th>
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
                    
                    $tampilSaldoDebit = $saldoDebit;
                    $tampilSaldoKredit = $saldoKredit;
                @endphp
                
                <!-- Saldo Awal -->
                <tr class="bg-info fw-bold">
                    <td class="text-center">
                        {{ isset($tanggalDari) ? \Carbon\Carbon::parse($tanggalDari)->format('M Y') : \Carbon\Carbon::now()->format('M Y') }}
                    </td>
                    <td colspan="4">SALDO AWAL ACCOUNTIMG</td>
                    <td class="text-right">
                        {{ $saldoDebit > 0 ? 'Rp ' . number_format($saldoDebit, 0, ',', '.') : '' }}
                    </td>
                    <td class="text-right">
                        {{ $saldoKredit > 0 ? 'Rp ' . number_format($saldoKredit, 0, ',', '.') : '' }}
                    </td>
                </tr>

                <!-- Detail Transaksi -->
                @if(isset($item['transaksi']) && count($item['transaksi']) > 0)
                    @foreach($item['transaksi'] as $transaksi)
                    @php
                        if($item['akun']->posisi_normal == 'Debit') {
                            $saldoDebit += $transaksi->debit;
                            $saldoKredit += $transaksi->kredit;
                        } else {
                            $saldoKredit += $transaksi->kredit;
                            $saldoDebit += $transaksi->debit;
                        }
                        
                        $saldoBersih = $saldoDebit - $saldoKredit;
                        $tampilSaldoDebit = $saldoBersih > 0 ? $saldoBersih : 0;
                        $tampilSaldoKredit = $saldoBersih < 0 ? abs($saldoBersih) : 0;
                    @endphp
                    <tr>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}
                        </td>
                        <td>{{ $transaksi->keterangan ?? '-' }}</td>
                        <td class="text-center">{{ $transaksi->ref ?? '' }}</td>
                        <td class="text-right">
                            @if($transaksi->debit > 0)
                                Rp {{ number_format($transaksi->debit, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right">
                            @if($transaksi->kredit > 0)
                                Rp {{ number_format($transaksi->kredit, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right">
                            @if($tampilSaldoDebit > 0)
                                Rp {{ number_format($tampilSaldoDebit, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right">
                            @if($tampilSaldoKredit > 0)
                                Rp {{ number_format($tampilSaldoKredit, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center text-muted" style="padding: 15px;">Tidak ada transaksi selama periode ini.</td>
                    </tr>
                @endif
                
                <!-- Saldo Akhir -->
                <tr class="bg-total fw-bold">
                    <td colspan="3" class="text-right">TOTAL MUTASI / SALDO AKHIR</td>
                    <td class="text-right" style="color: #10b981;">Rp {{ number_format($item['total_debit'], 0, ',', '.') }}</td>
                    <td class="text-right" style="color: #ef4444;">Rp {{ number_format($item['total_kredit'], 0, ',', '.') }}</td>
                    <td class="text-right" style="color: #1e3a8a;">
                        {{ $tampilSaldoDebit > 0 ? 'Rp ' . number_format($tampilSaldoDebit, 0, ',', '.') : '-' }}
                    </td>
                    <td class="text-right" style="color: #1e3a8a;">
                        {{ $tampilSaldoKredit > 0 ? 'Rp ' . number_format($tampilSaldoKredit, 0, ',', '.') : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
    @empty
        <div class="text-center" style="padding: 30px; border: 1px solid #cbd5e1; border-radius: 8px;">
            <h4>Belum Ada Data Buku Besar</h4>
            <p class="text-muted">Tidak ada akun aktif yang memiliki catatan mutasi pada filter yang dipilih.</p>
        </div>
    @endforelse
</body>
</html>


