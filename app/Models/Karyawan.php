<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'jabatan'
    ];

    // Relasi ke Pesanan
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }

    // Generate ID Karyawan otomatis
    public static function generateIdKaryawan()
    {
        $lastKaryawan = self::latest('id')->first();
        $lastNumber = $lastKaryawan ? intval(substr($lastKaryawan->id_karyawan, 3)) : 0;
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        return 'KRY' . $newNumber;
    }
}