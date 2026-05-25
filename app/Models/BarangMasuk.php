<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'nomor_transaksi',
        'barang_id',
        'jumlah',
        'harga_beli',
        'total_harga',
        'tanggal_masuk',
        'supplier',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_beli' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'tanggal_masuk' => 'date',
    ];

    // Relasi
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function serialNumbers()
    {
        return $this->hasMany(SerialNumber::class);
    }

    // Generate nomor transaksi otomatis
    public static function generateNomorTransaksi()
    {
        $date = now()->format('Ymd');
        $lastTransaction = self::whereDate('created_at', now())->latest()->first();
        
        if ($lastTransaction) {
            $lastNumber = intval(substr($lastTransaction->nomor_transaksi, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'BM-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}