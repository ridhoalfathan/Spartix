<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKartuStokController extends Controller
{
    public function index(Request $request)
    {
        $tanggalDari   = $request->filled('tanggal_dari')   ? $request->tanggal_dari   : date('Y-m-01');
        $tanggalSampai = $request->filled('tanggal_sampai') ? $request->tanggal_sampai : date('Y-m-d');

        $barangList     = Barang::orderBy('nama_barang')->get();
        $selectedBarang = null;
        $kartuStok      = null;

        if ($request->filled('barang_id')) {
            $selectedBarang = Barang::findOrFail($request->barang_id);
            $barangId       = $selectedBarang->id;

            // 1. Bangun FIFO stack dari saldo awal
            $snAwal = SerialNumber::where('barang_id', $barangId)
                ->where('tanggal_masuk', '<', $tanggalDari)
                ->where(function ($q) use ($tanggalDari) {
                    $q->where('status', 'READY')
                      ->orWhere(function ($q2) use ($tanggalDari) {
                          $q2->where('status', 'TERJUAL')
                             ->where('tanggal_keluar', '>=', $tanggalDari);
                      });
                })
                ->orderBy('tanggal_masuk')->orderBy('id')
                ->get(['barang_masuk_id', 'harga_beli', 'tanggal_masuk']);

            $layerAwalMap = [];
            foreach ($snAwal as $sn) {
                $key = $sn->barang_masuk_id . '_' . number_format($sn->harga_beli, 2, '.', '');
                if (!isset($layerAwalMap[$key])) {
                    $layerAwalMap[$key] = ['harga' => (float) $sn->harga_beli, 'qty' => 0];
                }
                $layerAwalMap[$key]['qty']++;
            }
            $fifoStack = array_values($layerAwalMap);

            $saldoAwalQty    = $snAwal->count();
            $saldoAwalNilai  = (float) $snAwal->sum('harga_beli');
            $saldoAwalLayers = $this->snapshotStack($fifoStack);

            // 2. Mutasi masuk dalam periode
            $masukList = BarangMasuk::where('barang_id', $barangId)
                ->whereBetween('tanggal_masuk', [$tanggalDari, $tanggalSampai])
                ->orderBy('tanggal_masuk')->orderBy('id')->get();

            // 3. Mutasi keluar dalam periode
            $keluarList = BarangKeluar::where('barang_id', $barangId)
                ->whereBetween('tanggal_keluar', [$tanggalDari, $tanggalSampai])
                ->with('serialNumber:id,harga_beli,barang_masuk_id')
                ->orderBy('tanggal_keluar')->orderBy('nomor_transaksi')->orderBy('id')->get();

            // 4. Gabung & urutkan events
            $events = collect();
            foreach ($masukList as $bm) {
                $events->push(['sort_tgl' => $bm->tanggal_masuk->format('Y-m-d'), 'sort_tipe' => 0, 'tipe' => 'masuk', 'data' => $bm]);
            }
            foreach ($keluarList->groupBy('nomor_transaksi') as $group) {
                $events->push(['sort_tgl' => $group->first()->tanggal_keluar->format('Y-m-d'), 'sort_tipe' => 1, 'tipe' => 'keluar', 'data' => $group]);
            }
            $events = $events->sortBy([['sort_tgl', 'asc'], ['sort_tipe', 'asc']])->values();

            // 5. Proses FIFO stack
            $rows = [];
            $totalMasukQty = 0;  $totalMasukNilai = 0;
            $totalKeluarQty = 0; $totalKeluarNilai = 0;

            foreach ($events as $event) {
                if ($event['tipe'] === 'masuk') {
                    $bm    = $event['data'];
                    $qty   = (int) $bm->jumlah;
                    $harga = (float) $bm->harga_beli;
                    $nilai = (float) $bm->total_harga;

                    $fifoStack[] = ['harga' => $harga, 'qty' => $qty];
                    $totalMasukQty   += $qty;
                    $totalMasukNilai += $nilai;

                    $rows[] = [
                        'tanggal'       => $bm->tanggal_masuk,
                        'keterangan'    => 'Pembelian dari ' . ($bm->supplier ?? '-'),
                        'tipe'          => 'masuk',
                        'masuk_layers'  => [['qty' => $qty, 'harga' => $harga, 'nilai' => $nilai]],
                        'keluar_layers' => [],
                        'saldo_layers'  => $this->snapshotStack($fifoStack),
                        'saldo_qty'     => array_sum(array_column($fifoStack, 'qty')),
                        'saldo_nilai'   => $this->stackNilai($fifoStack),
                    ];
                } else {
                    $group        = $event['data'];
                    $first        = $group->first();
                    $sisaKeluar   = $group->count();
                    $keluarLayers = [];

                    foreach ($fifoStack as &$layer) {
                        if ($sisaKeluar <= 0) break;
                        $ambil = min($layer['qty'], $sisaKeluar);
                        if ($ambil > 0) {
                            $keluarLayers[] = ['qty' => $ambil, 'harga' => $layer['harga'], 'nilai' => $ambil * $layer['harga']];
                            $layer['qty']  -= $ambil;
                            $sisaKeluar    -= $ambil;
                        }
                    }
                    unset($layer);
                    $fifoStack = array_values(array_filter($fifoStack, fn ($l) => $l['qty'] > 0));

                    $qtyKeluar   = array_sum(array_column($keluarLayers, 'qty'));
                    $nilaiKeluar = array_sum(array_column($keluarLayers, 'nilai'));
                    $totalKeluarQty   += $qtyKeluar;
                    $totalKeluarNilai += $nilaiKeluar;

                    $rows[] = [
                        'tanggal'       => $first->tanggal_keluar,
                        'keterangan'    => 'Penjualan ke ' . ($first->customer ?? '-'),
                        'tipe'          => 'keluar',
                        'masuk_layers'  => [],
                        'keluar_layers' => $keluarLayers,
                        'saldo_layers'  => $this->snapshotStack($fifoStack),
                        'saldo_qty'     => array_sum(array_column($fifoStack, 'qty')),
                        'saldo_nilai'   => $this->stackNilai($fifoStack),
                    ];
                }
            }

            $kartuStok = [
                'barang'             => $selectedBarang,
                'tanggal_dari'       => $tanggalDari,
                'tanggal_sampai'     => $tanggalSampai,
                'saldo_awal_qty'     => $saldoAwalQty,
                'saldo_awal_nilai'   => $saldoAwalNilai,
                'saldo_awal_layers'  => $saldoAwalLayers,
                'rows'               => $rows,
                'total_masuk_qty'    => $totalMasukQty,
                'total_masuk_nilai'  => $totalMasukNilai,
                'total_keluar_qty'   => $totalKeluarQty,
                'total_keluar_nilai' => $totalKeluarNilai,
                'saldo_akhir_qty'    => array_sum(array_column($fifoStack, 'qty')),
                'saldo_akhir_nilai'  => $this->stackNilai($fifoStack),
                'saldo_akhir_layers' => $this->snapshotStack($fifoStack),
            ];
        }

        if ($request->export === 'pdf' && $kartuStok) {
            $pdf = Pdf::loadView('laporan.kartu-stok-pdf', compact('kartuStok'))
                ->setPaper('a4', 'landscape');
            $filename = 'Kartu_Stok_' . str_replace(' ', '_', $selectedBarang->nama_barang) . '_' . date('Y-m-d') . '.pdf';
            return $pdf->download($filename);
        }

        return view('laporan.kartu-stok', compact('barangList', 'selectedBarang', 'kartuStok', 'tanggalDari', 'tanggalSampai'));
    }

    private function snapshotStack(array $stack): array
    {
        return array_values(array_filter(array_map(
            fn ($l) => $l['qty'] > 0 ? ['qty' => $l['qty'], 'harga' => $l['harga'], 'nilai' => $l['qty'] * $l['harga']] : null,
            $stack
        )));
    }

    private function stackNilai(array $stack): float
    {
        return (float) array_sum(array_map(fn ($l) => $l['qty'] * $l['harga'], $stack));
    }
}
