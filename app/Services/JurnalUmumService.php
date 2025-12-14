<?php

namespace App\Services;

use App\Models\JurnalUmum;
use App\Models\Pembelian;
use App\Models\Transaksi;
use App\Models\SalaryReport;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JurnalUmumService
{
    /**
     * Ambil nilai pertama yang ada dari array kemungkinan nama field
     */
    protected function valueFrom($model, array $keys, $default = null)
    {
        foreach ($keys as $k) {
            // Cek properti Eloquent
            if (isset($model->{$k})) {
                return $model->{$k};
            }

            // Cek existence via hasAttribute (in case of array-like)
            if (is_array($model) && array_key_exists($k, $model)) {
                return $model[$k];
            }
        }

        return $default;
    }

    /**
     * Normalisasi tanggal
     */
    protected function normalizeDate($value)
    {
        if (!$value) {
            return now();
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return now();
        }
    }

    /**
     * Ambil nominal (cek banyak nama field kemungkinan)
     */
    protected function getNominal($model, array $possibleKeys)
    {
        $val = $this->valueFrom($model, $possibleKeys, 0);
        // cast to float/integer
        return is_numeric($val) ? (float) $val : 0;
    }

    /**
     * Ambil keterangan/deskripsi
     */
    protected function getKeterangan($model, array $possibleKeys, $fallback = '')
    {
        $val = $this->valueFrom($model, $possibleKeys, null);
        if ($val) {
            return (string) $val;
        }

        // build fallback using available fields
        $names = [];
        foreach (['nama_barang','nama_supplier','karyawan_id','karyawan_name','name','title'] as $k) {
            $v = $this->valueFrom($model, [$k], null);
            if ($v) $names[] = $v;
        }

        return $fallback . ($names ? ' - ' . implode(' / ', $names) : '');
    }

    /**
     * Create jurnal untuk pembelian (robust terhadap variasi nama kolom)
     */
    public function generateFromPembelian(Pembelian $pembelian)
    {
        // Cek apakah sudah ada jurnal untuk pembelian ini
        $exists = JurnalUmum::where('sumber_transaksi', 'pembelian')
            ->where('sumber_id', $pembelian->id)
            ->exists();

        if ($exists) {
            return null; // Sudah ada, skip
        }

        $tanggal = $this->normalizeDate($this->valueFrom($pembelian, ['tanggal_pembelian','tanggal','date','created_at'], now()));
        $nominal = $this->getNominal($pembelian, ['total_pembelian','total','total_harga','amount','grand_total']);
        $keterangan = $this->getKeterangan($pembelian, ['keterangan','description','notes'], 'Pembelian');

        // Jika nominal 0 maka skip untuk menghindari entri kosong
        if ($nominal <= 0) {
            return null;
        }

        return JurnalUmum::create([
            'tanggal' => $tanggal,
            'keterangan' => 'Pembelian - ' . $keterangan,
            'akun_debit' => 'Pembelian',
            'debit' => $nominal,
            'akun_kredit' => 'Kas',
            'kredit' => $nominal,
            'sumber_transaksi' => 'pembelian',
            'sumber_id' => $pembelian->id,
            'no_referensi' => 'PB-' . $this->valueFrom($pembelian, ['id_pembelian','id','no_referensi'], $pembelian->id)
        ]);
    }

    /**
     * Create jurnal untuk transaksi/penjualan
     */
    public function generateFromTransaksi(Transaksi $transaksi)
    {
        $exists = JurnalUmum::where('sumber_transaksi', 'transaksi')
            ->where('sumber_id', $transaksi->id)
            ->exists();

        if ($exists) {
            return null;
        }

        $tanggal = $this->normalizeDate($this->valueFrom($transaksi, ['tanggal','date','created_at'], now()));
        $nominal = $this->getNominal($transaksi, ['total_transaksi','total','total_harga','amount','grand_total']);
        $keterangan = $this->getKeterangan($transaksi, ['keterangan','description','notes','nama_barang'], 'Penjualan');

        if ($nominal <= 0) {
            return null;
        }

        return JurnalUmum::create([
            'tanggal' => $tanggal,
            'keterangan' => 'Penjualan - ' . $keterangan,
            'akun_debit' => 'Kas',
            'debit' => $nominal,
            'akun_kredit' => 'Pendapatan Penjualan',
            'kredit' => $nominal,
            'sumber_transaksi' => 'transaksi',
            'sumber_id' => $transaksi->id,
            'no_referensi' => 'TR-' . $this->valueFrom($transaksi, ['id_transaksi','id','no_referensi'], $transaksi->id)
        ]);
    }

    /**
     * Create jurnal untuk salary report (gaji)
     */
    public function generateFromSalaryReport(SalaryReport $salaryReport)
    {
        $exists = JurnalUmum::where('sumber_transaksi', 'salary_report')
            ->where('sumber_id', $salaryReport->id)
            ->exists();

        if ($exists) {
            return null;
        }

        $tanggal = $this->normalizeDate($this->valueFrom($salaryReport, ['tanggal','tanggal_gaji','date','created_at'], now()));
        $nominal = $this->getNominal($salaryReport, ['total_gaji','total','amount','gaji_total']);
        $keterangan = $this->getKeterangan($salaryReport, ['keterangan','notes'], 'Pembayaran Gaji');

        if ($nominal <= 0) {
            return null;
        }

        // Ambil nama karyawan jika tersedia
        $namaKaryawan = $this->valueFrom($salaryReport, ['karyawan_name','nama_karyawan','karyawan.nama'], null);
        $keteranganFull = trim('Pembayaran Gaji' . ($namaKaryawan ? ' - ' . $namaKaryawan : '') . ' ' . $keterangan);

        return JurnalUmum::create([
            'tanggal' => $tanggal,
            'keterangan' => $keteranganFull,
            'akun_debit' => 'Beban Gaji',
            'debit' => $nominal,
            'akun_kredit' => 'Kas',
            'kredit' => $nominal,
            'sumber_transaksi' => 'salary_report',
            'sumber_id' => $salaryReport->id,
            'no_referensi' => 'SAL-' . $this->valueFrom($salaryReport, ['id','no_referensi'], $salaryReport->id)
        ]);
    }

    /**
     * Sync semua pembelian yang complete (case-insensitive)
     */
    public function syncAllPembelian()
    {
        $pembelians = Pembelian::whereIn(DB::raw('LOWER(status)'), ['complete','completed','selesai'])
            ->whereNotIn('id', function($query) {
                $query->select('sumber_id')
                    ->from('jurnal_umums')
                    ->where('sumber_transaksi', 'pembelian');
            })
            ->get();

        $count = 0;
        foreach ($pembelians as $pembelian) {
            if ($this->generateFromPembelian($pembelian)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Sync semua transaksi yang sukses (case-insensitive)
     */
    public function syncAllTransaksi()
    {
        $transaksis = Transaksi::whereIn(DB::raw('LOWER(status)'), ['sukses','success','paid'])
            ->whereNotIn('id', function($query) {
                $query->select('sumber_id')
                    ->from('jurnal_umums')
                    ->where('sumber_transaksi', 'transaksi');
            })
            ->get();

        $count = 0;
        foreach ($transaksis as $transaksi) {
            if ($this->generateFromTransaksi($transaksi)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Sync semua salary report where paid
     */
    public function syncAllSalaryReports()
    {
        $salaryReports = SalaryReport::whereIn(DB::raw('LOWER(status)'), ['paid','lunas','dibayar'])
            ->whereNotIn('id', function($query) {
                $query->select('sumber_id')
                    ->from('jurnal_umums')
                    ->where('sumber_transaksi', 'salary_report');
            })
            ->get();

        $count = 0;
        foreach ($salaryReports as $salaryReport) {
            if ($this->generateFromSalaryReport($salaryReport)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Sync semua data sekaligus
     */
    public function syncAll()
    {
        DB::beginTransaction();
        try {
            $pembelianCount = $this->syncAllPembelian();
            $transaksiCount = $this->syncAllTransaksi();
            $salaryCount = $this->syncAllSalaryReports();

            DB::commit();

            return [
                'pembelian' => $pembelianCount,
                'transaksi' => $transaksiCount,
                'salary' => $salaryCount,
                'total' => $pembelianCount + $transaksiCount + $salaryCount
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete jurnal by sumber
     */
    public function deleteBySource($sumberTransaksi, $sumberId)
    {
        return JurnalUmum::where('sumber_transaksi', $sumberTransaksi)
            ->where('sumber_id', $sumberId)
            ->delete();
    }

    /**
     * Update jurnal when source updated
     */
    public function updateFromSource($sumberTransaksi, $sumberId)
    {
        $jurnal = JurnalUmum::where('sumber_transaksi', $sumberTransaksi)
            ->where('sumber_id', $sumberId)
            ->first();

        if (!$jurnal) {
            return null;
        }

        if ($sumberTransaksi === 'pembelian') {
            $pembelian = Pembelian::find($sumberId);
            if ($pembelian) {
                $nominal = $this->getNominal($pembelian, ['total_pembelian','total','total_harga','amount','grand_total']);
                $jurnal->update([
                    'tanggal' => $this->normalizeDate($this->valueFrom($pembelian, ['tanggal_pembelian','tanggal','date','created_at'], now())),
                    'debit' => $nominal,
                    'kredit' => $nominal,
                ]);
            }
        } elseif ($sumberTransaksi === 'transaksi') {
            $transaksi = Transaksi::find($sumberId);
            if ($transaksi) {
                $nominal = $this->getNominal($transaksi, ['total_transaksi','total','total_harga','amount','grand_total']);
                $jurnal->update([
                    'tanggal' => $this->normalizeDate($this->valueFrom($transaksi, ['tanggal','date','created_at'], now())),
                    'debit' => $nominal,
                    'kredit' => $nominal,
                ]);
            }
        } elseif ($sumberTransaksi === 'salary_report') {
            $salary = SalaryReport::find($sumberId);
            if ($salary) {
                $nominal = $this->getNominal($salary, ['total_gaji','total','amount','gaji_total']);
                $jurnal->update([
                    'tanggal' => $this->normalizeDate($this->valueFrom($salary, ['tanggal','tanggal_gaji','date','created_at'], now())),
                    'debit' => $nominal,
                    'kredit' => $nominal,
                ]);
            }
        }

        return $jurnal;
    }
}
