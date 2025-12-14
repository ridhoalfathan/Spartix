<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'karyawan_id',
        'tanggal',
        'waktu',
        'quantity',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'quantity' => 'integer',
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    // Event untuk menambah stok otomatis ketika status berubah menjadi Selesai
    protected static function booted()
    {
        static::updating(function ($produksi) {
            // Cek apakah status berubah menjadi Selesai
            if ($produksi->isDirty('status') && $produksi->status === 'Selesai') {
                // Cek apakah status sebelumnya bukan Selesai (untuk menghindari duplikasi)
                if ($produksi->getOriginal('status') !== 'Selesai') {
                    // Tambah stok produk
                    $produksi->product->addStock($produksi->quantity);
                }
            }
            
            // Jika status diubah dari Selesai ke status lain, kurangi stok
            if ($produksi->isDirty('status') && $produksi->getOriginal('status') === 'Selesai' && $produksi->status !== 'Selesai') {
                $produksi->product->reduceStock($produksi->quantity);
            }
        });
    }
}