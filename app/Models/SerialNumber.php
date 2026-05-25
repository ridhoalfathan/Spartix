<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialNumber extends Model
{
    use HasFactory;

    protected $table = 'serial_numbers';

    protected $fillable = [
        'serial_number',
        'barang_id',
        'barang_masuk_id',
        'harga_beli',
        'status',
        'tanggal_masuk',
        'tanggal_keluar',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    // Relasi
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function barangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasOne(BarangKeluar::class);
    }

    // Scope untuk serial number yang ready
    public function scopeReady($query)
    {
        return $query->where('status', 'READY');
    }

    // Scope untuk serial number yang terjual
    public function scopeTerjual($query)
    {
        return $query->where('status', 'TERJUAL');
    }

    // Accessor untuk badge class
    public function getBadgeClassAttribute()
    {
        return $this->status === 'READY' ? 'success' : 'secondary';
    }
}