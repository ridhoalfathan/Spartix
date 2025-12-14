<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pesanan',
        'product_id',
        'nama_pemesan',
        'jumlah_pesanan',
        'tanggal_pembayaran',
        'status',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'jumlah_pesanan' => 'integer',
    ];

    // Relationship dengan Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'pesanan_id');
    }
    // Generate ID Pesanan otomatis
    public static function generateIdPesanan()
    {
        $lastPesanan = self::latest('id')->first();
        
        if (!$lastPesanan) {
            return 'PSN-0001';
        }
        
        $lastNumber = intval(substr($lastPesanan->id_pesanan, 4));
        $newNumber = $lastNumber + 1;
        
        return 'PSN-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Boot method untuk auto generate ID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pesanan) {
            if (empty($pesanan->id_pesanan)) {
                $pesanan->id_pesanan = self::generateIdPesanan();
            }
        });
    }
}