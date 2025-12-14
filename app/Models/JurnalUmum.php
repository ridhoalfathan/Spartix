<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'keterangan',
        'akun_debit',
        'debit',
        'akun_kredit',
        'kredit',
        'sumber_transaksi',
        'sumber_id',
        'no_referensi'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'debit' => 'decimal:2',
        'kredit' => 'decimal:2'
    ];

    /**
     * Set default values untuk mencegah NULL
     */
    protected $attributes = [
        'debit' => 0,
        'kredit' => 0,
    ];

    /**
     * Boot method untuk validasi sebelum save
     */
    protected static function boot()
    {
        parent::boot();

        // Event sebelum create/update
        static::saving(function ($model) {
            // Pastikan debit dan kredit tidak NULL
            $model->debit = $model->debit ?? 0;
            $model->kredit = $model->kredit ?? 0;

            // Konversi ke float untuk memastikan tipe data benar
            $model->debit = (float) $model->debit;
            $model->kredit = (float) $model->kredit;

            // Pastikan tidak negatif
            $model->debit = max(0, $model->debit);
            $model->kredit = max(0, $model->kredit);
        });
    }

    /**
     * Mutator untuk debit - pastikan tidak NULL
     */
    public function setDebitAttribute($value)
    {
        $this->attributes['debit'] = $value !== null ? (float) $value : 0;
    }

    /**
     * Mutator untuk kredit - pastikan tidak NULL
     */
    public function setKreditAttribute($value)
    {
        $this->attributes['kredit'] = $value !== null ? (float) $value : 0;
    }

    /**
     * Relasi polymorphic ke sumber transaksi
     */
    public function sumber()
    {
        if ($this->sumber_transaksi === 'pembelian') {
            return $this->belongsTo(Pembelian::class, 'sumber_id');
        } elseif ($this->sumber_transaksi === 'transaksi') {
            return $this->belongsTo(Transaksi::class, 'sumber_id');
        } elseif ($this->sumber_transaksi === 'salary_report') {
            return $this->belongsTo(SalaryReport::class, 'sumber_id');
        }
        return null;
    }

    /**
     * Scope untuk filter berdasarkan range tanggal
     */
    public function scopeFilterByDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate && $endDate) {
            return $query->whereBetween('tanggal', [$startDate, $endDate]);
        } elseif ($startDate) {
            return $query->where('tanggal', '>=', $startDate);
        } elseif ($endDate) {
            return $query->where('tanggal', '<=', $endDate);
        }
        
        return $query;
    }

    /**
     * Scope untuk filter berdasarkan akun
     */
    public function scopeByAkun($query, $namaAkun)
    {
        return $query->where(function($q) use ($namaAkun) {
            $q->where('akun_debit', $namaAkun)
              ->orWhere('akun_kredit', $namaAkun);
        });
    }

    /**
     * Scope untuk filter by sumber
     */
    public function scopeBySumber($query, $sumber)
    {
        return $query->where('sumber_transaksi', $sumber);
    }

    /**
     * Cek apakah jurnal balance (debit = kredit)
     */
    public function isBalanced()
    {
        return abs($this->debit - $this->kredit) < 0.01; // toleransi untuk floating point
    }

    /**
     * Get selisih debit dan kredit
     */
    public function getSelisihAttribute()
    {
        return abs($this->debit - $this->kredit);
    }

    /**
     * Format debit ke Rupiah
     */
    public function getFormattedDebitAttribute()
    {
        return 'Rp ' . number_format($this->debit ?? 0, 0, ',', '.');
    }

    /**
     * Format kredit ke Rupiah
     */
    public function getFormattedKreditAttribute()
    {
        return 'Rp ' . number_format($this->kredit ?? 0, 0, ',', '.');
    }

    /**
     * Check if jurnal is manual entry
     */
    public function isManual()
    {
        return $this->sumber_transaksi === 'manual' || $this->sumber_transaksi === null;
    }

    /**
     * Get kategori akun berdasarkan nama akun
     */
    public function getKategoriAkun($namaAkun)
    {
        $kategoriList = [
            'Aset' => ['Kas', 'Bank', 'Piutang', 'Persediaan', 'Perlengkapan', 'Peralatan', 'Kendaraan', 'Gedung', 'Tanah', 'Sewa Dibayar Dimuka', 'Asuransi Dibayar Dimuka', 'Akumulasi'],
            'Liabilitas' => ['Utang'],
            'Ekuitas' => ['Modal', 'Prive', 'Laba'],
            'Pendapatan' => ['Pendapatan', 'Penjualan'],
            'Beban' => ['Beban', 'Pembelian'],
        ];

        foreach ($kategoriList as $kategori => $keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($namaAkun, $keyword) !== false) {
                    return $kategori;
                }
            }
        }

        return 'Lainnya';
    }

    /**
     * Static method untuk create jurnal dengan validasi
     */
    public static function createJurnal(array $data)
    {
        // Validasi dan set default
        $data['debit'] = $data['debit'] ?? 0;
        $data['kredit'] = $data['kredit'] ?? 0;
        $data['tanggal'] = $data['tanggal'] ?? now();

        // Pastikan numeric
        $data['debit'] = (float) $data['debit'];
        $data['kredit'] = (float) $data['kredit'];

        return self::create($data);
    }
}