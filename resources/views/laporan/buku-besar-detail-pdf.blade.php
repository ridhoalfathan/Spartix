<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Buku Besar - {{ $akun->nama_akun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .account-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }
        .account-info table {
            width: 100%;
            border: none;
        }
        .account-info td {
            padding: 3px 5px;
            border: none;
        }
        table.transactions {
            width: 100%;
            border-collapse: collapse;
        }
        table.transactions th, table.transactions td {
            border: 1px solid #ddd;
            padding: 6px 8px;
        }
        table.transactions th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .saldo-awal {
            background-color: #e8f4f8;
            font-weight: bold;
        }
        .saldo-akhir {
            background-color: #d4edda;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>DETAIL BUKU BESAR</h2>
        <p>RAYA-E - Sistem Persediaan Elektronik</p>
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>

    <div class="account-info">
        <table>
            <tr>
                <td width="20%"><strong>Kode Akun</strong></td>
                <td width="30%">: {{ $akun->kode_akun }}</td>
                <td width="20%"><strong>Posisi Normal</strong></td>
                <td width="30%">: {{ $akun->posisi_normal }}</td>
            </tr>
            <tr>
                <td><strong>Nama Akun</strong></td>
                <td>: {{ $akun->nama_akun }}</td>
                <td><strong>Saldo Awal</strong></td>
                <td>: Rp {{ number_format($akun->saldo_normal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Tipe Akun</strong></td>
                <td>: {{ $akun->tipe_akun }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <table class="transactions">
        <thead>
            <tr>
                <th width="10%">Tanggal</th>
                <th width="15%">No. Jurnal</th>
                <th width="35%">Keterangan</th>
                <th width="13%" class="text-right">Debit</th>
                <th width="13%" class="text-right">Kredit</th>
                <th width="14%" class="text-right">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <!-- Saldo Awal -->
            <tr class="saldo-awal">
                <td colspan="3">SALDO AWAL</td>
                <td class="text-right">-</td>
                <td class="text-right">-</td>
                <td class="text-right">Rp {{ number_format($akun->saldo_normal, 0, ',', '.') }}</td>
            </tr>

            @foreach($detailsWithBalance as $item)
            <tr>
                <td>{{ $item['detail']->jurnalEntry->tanggal->format('d/m/Y') }}</td>
                <td>{{ $item['detail']->jurnalEntry->no_jurnal }}</td>
                <td>{{ $item['detail']->keterangan ?? $item['detail']->jurnalEntry->keterangan }}</td>
                <td class="text-right">
                    @if($item['detail']->debit > 0)
                        Rp {{ number_format($item['detail']->debit, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">
                    @if($item['detail']->kredit > 0)
                        Rp {{ number_format($item['detail']->kredit, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format(abs($item['saldo']), 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <!-- Saldo Akhir -->
            @if(count($detailsWithBalance) > 0)
            <tr class="saldo-akhir">
                <td colspan="3" class="text-right">SALDO AKHIR</td>
                <td class="text-right">Rp {{ number_format(collect($detailsWithBalance)->sum('detail.debit'), 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format(collect($detailsWithBalance)->sum('detail.kredit'), 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format(abs(end($detailsWithBalance)['saldo']), 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>--- End of Report ---</p>
    </div>
</body>
</html>

