<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaksi',
        'pesanan_id',
        'nama_pengirim',
        'nama_bank',
        'nomor_rekening',
        'total_transaksi',
        'tanggal',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_transaksi' => 'decimal:2'
    ];

    // Relasi ke Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    // Generate ID Transaksi otomatis
    public static function generateIdTransaksi()
    {
        $lastTransaksi = self::latest('id')->first();
        $lastNumber = $lastTransaksi ? intval(substr($lastTransaksi->id_transaksi, 3)) : 0;
        $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        return 'TRX' . $newNumber;
    }
}