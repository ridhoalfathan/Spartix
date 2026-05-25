<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = 'akuns';

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'tipe_akun',
        'kategori',
        'saldo_normal',
        'posisi_normal',
        'parent_id',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'saldo_normal' => 'decimal:2',
        'is_active'    => 'boolean',
    ];

    // Relasi parent (akun induk)
    public function parent()
    {
        return $this->belongsTo(Akun::class, 'parent_id');
    }

    // Relasi children (sub akun)
    public function children()
    {
        return $this->hasMany(Akun::class, 'parent_id');
    }

    // Scope untuk filter aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk filter tipe akun
    public function scopeByType($query, $type)
    {
        return $query->where('tipe_akun', $type);
    }

    // Get full account name with parent
    public function getFullNameAttribute()
    {
        if ($this->parent) {
            return $this->parent->nama_akun . ' > ' . $this->nama_akun;
        }
        return $this->nama_akun;
    }
}
