<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pembelian',
        'nama_supplier',
        'nama_barang',
        'total_pembelian',
        'tanggal_pembelian',
        'status'
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'total_pembelian' => 'decimal:2'
    ];
}