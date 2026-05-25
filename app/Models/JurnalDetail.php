<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalDetail extends Model
{
    protected $fillable = [
        'jurnal_entry_id',
        'akun_id',
        'debit',
        'kredit',
        'keterangan'
    ];

    protected $casts = [
        'debit'  => 'decimal:2',
        'kredit' => 'decimal:2',
    ];

    public function jurnalEntry()
    {
        return $this->belongsTo(JurnalEntry::class);
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
