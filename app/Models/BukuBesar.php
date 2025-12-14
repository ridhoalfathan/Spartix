<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuBesar extends Model
{
    use HasFactory;

    protected $table = 'buku_besar';

    protected $fillable = [
        'jurnal_umum_id',
        'nama_akun',
        'tanggal',
        'keterangan',
        'no_referensi',
        'debit',
        'kredit',
        'saldo'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'debit' => 'decimal:2',
        'kredit' => 'decimal:2',
        'saldo' => 'decimal:2',
    ];

    public function jurnalUmum()
    {
        return $this->belongsTo(JurnalUmum::class);
    }

    // Get 3 akun utama
    public static function getDaftarAkun()
    {
        return ['Kas', 'Pendapatan Usaha', 'Beban Gaji'];
    }
}