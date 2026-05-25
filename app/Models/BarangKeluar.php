<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluar';

    protected $fillable = [
        'nomor_transaksi',
        'barang_id',
        'serial_number_id',
        'hpp',
        'harga_jual',
        'laba',
        'tanggal_keluar',
        'customer',
        'metode_pembayaran',
    ];

    protected $casts = [
        'hpp' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'laba' => 'decimal:2',
        'tanggal_keluar' => 'date',
    ];

    // Relasi
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function serialNumber()
    {
        return $this->belongsTo(SerialNumber::class);
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
        
        return 'BK-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}