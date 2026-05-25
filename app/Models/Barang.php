<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'merk',
        'harga',
        'stok',
        'stok_minimum',
        'metode',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'stok_minimum' => 'integer',
    ];

    // Relasi
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }

    public function serialNumbers()
    {
        return $this->hasMany(SerialNumber::class);
    }

    // Accessor untuk status stok
    public function getStatusStokAttribute()
    {
        if ($this->stok <= 0) {
            return 'Habis';
        } elseif ($this->stok <= $this->stok_minimum) {
            return 'Rendah';
        }
        return 'Normal';
    }

    // Accessor untuk badge class
    public function getBadgeClassAttribute()
    {
        switch ($this->status_stok) {
            case 'Habis':
                return 'danger';
            case 'Rendah':
                return 'warning';
            default:
                return 'success';
        }
    }

    // Accessor untuk format harga
    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}