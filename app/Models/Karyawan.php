<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'jabatan',
        'kategori',
        'hasil'
    ];
}