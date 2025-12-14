<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'gaji_per_jam',
        'lama_bekerja',
        'bonus',
        'total',
        'status',
        'tanggal_pembayaran',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'gaji_per_jam' => 'decimal:2',
        'lama_bekerja' => 'decimal:2',
        'bonus' => 'decimal:2',
        'total' => 'decimal:2',
        'tanggal_pembayaran' => 'date',
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'status' => 'pending',
        'bonus' => 0,
    ];

    /**
     * Boot method untuk auto-calculate dan validasi
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Auto calculate total
            $gajiPerJam = $model->gaji_per_jam ?? 0;
            $lamaBekerja = $model->lama_bekerja ?? 0;
            $bonus = $model->bonus ?? 0;
            
            $model->total = ($gajiPerJam * $lamaBekerja) + $bonus;
            
            // Pastikan tidak ada nilai negatif
            $model->gaji_per_jam = max(0, $gajiPerJam);
            $model->lama_bekerja = max(0, $lamaBekerja);
            $model->bonus = max(0, $bonus);
            $model->total = max(0, $model->total);
        });

        // Event setelah status berubah menjadi 'paid'
        static::updated(function ($model) {
            if ($model->isDirty('status') && $model->status === 'paid') {
                // Auto-create jurnal jika belum ada
                if (!$model->isDijurnal()) {
                    $model->buatJurnal();
                }
            }
        });
    }

    /**
     * Relasi ke Karyawan
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    /**
     * Relasi ke Jurnal Umum
     */
    public function jurnalUmum()
    {
        return $this->hasMany(JurnalUmum::class, 'sumber_id')
                    ->where('sumber_transaksi', 'salary_report');
    }

    /**
     * Scope untuk filter status
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope untuk salary yang belum dijurnal
     */
    public function scopeBelumDijurnal($query)
    {
        return $query->whereNotIn('id', function($subquery) {
            $subquery->select('sumber_id')
                     ->from('jurnal_umums')
                     ->where('sumber_transaksi', 'salary_report');
        });
    }

    /**
     * Scope untuk filter berdasarkan periode tanggal
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
     * Scope untuk filter by karyawan
     */
    public function scopeByKaryawan($query, $karyawanId)
    {
        return $query->where('karyawan_id', $karyawanId);
    }

    /**
     * Check apakah sudah dijurnal
     */
    public function isDijurnal()
    {
        return $this->jurnalUmum()->exists();
    }

    /**
     * Mark as paid dan buat jurnal
     */
    public function markAsPaid($tanggalPembayaran = null)
    {
        $this->update([
            'status' => 'paid',
            'tanggal_pembayaran' => $tanggalPembayaran ?? now(),
        ]);

        return $this;
    }

    /**
     * Mark as cancelled
     */
    public function cancel($alasan = null)
    {
        $this->update([
            'status' => 'cancelled',
            'keterangan' => $alasan,
        ]);

        return $this;
    }

    /**
     * Buat jurnal untuk pembayaran gaji
     */
    public function buatJurnal()
    {
        // Cek apakah sudah ada jurnal
        if ($this->isDijurnal()) {
            return $this->jurnalUmum()->first();
        }

        $namaKaryawan = $this->karyawan ? $this->karyawan->nama : 'Karyawan';
        $tanggalFormat = $this->tanggal->format('d/m/Y');

        return JurnalUmum::create([
            'tanggal' => $this->tanggal_pembayaran ?? $this->tanggal ?? now(),
            'keterangan' => "Pembayaran Gaji - {$namaKaryawan} ({$tanggalFormat})",
            'akun_debit' => 'Beban Gaji',
            'debit' => $this->total,
            'akun_kredit' => 'Kas',
            'kredit' => $this->total,
            'sumber_transaksi' => 'salary_report',
            'sumber_id' => $this->id,
            'no_referensi' => 'GAJI-' . str_pad($this->id, 5, '0', STR_PAD_LEFT),
        ]);
    }

    /**
     * Hapus jurnal terkait (jika dibatalkan)
     */
    public function hapusJurnal()
    {
        return $this->jurnalUmum()->delete();
    }

    /**
     * Format total ke Rupiah
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total ?? 0, 0, ',', '.');
    }

    /**
     * Format gaji per jam ke Rupiah
     */
    public function getFormattedGajiPerJamAttribute()
    {
        return 'Rp ' . number_format($this->gaji_per_jam ?? 0, 0, ',', '.');
    }

    /**
     * Format bonus ke Rupiah
     */
    public function getFormattedBonusAttribute()
    {
        return 'Rp ' . number_format($this->bonus ?? 0, 0, ',', '.');
    }

    /**
     * Get status badge color untuk UI
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status ?? 'pending') {
            'paid' => 'success',
            'pending' => 'warning',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get status label Indonesia
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status ?? 'pending') {
            'paid' => 'Sudah Dibayar',
            'pending' => 'Menunggu Pembayaran',
            'cancelled' => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Check apakah bisa dibayar
     */
    public function canBePaid()
    {
        return $this->status === 'pending';
    }

    /**
     * Check apakah bisa dibatalkan
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'paid']);
    }

    /**
     * Get detail gaji lengkap
     */
    public function getDetailGaji()
    {
        return [
            'gaji_pokok' => $this->gaji_per_jam * $this->lama_bekerja,
            'bonus' => $this->bonus,
            'total' => $this->total,
            'formatted' => [
                'gaji_pokok' => 'Rp ' . number_format($this->gaji_per_jam * $this->lama_bekerja, 0, ',', '.'),
                'bonus' => 'Rp ' . number_format($this->bonus, 0, ',', '.'),
                'total' => $this->formatted_total,
            ]
        ];
    }
}