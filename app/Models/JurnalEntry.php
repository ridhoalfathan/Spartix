<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalEntry extends Model
{
    protected $fillable = [
        'no_jurnal',
        'tanggal',
        'referensi',
        'referensi_type',
        'keterangan',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function details()
    {
        return $this->hasMany(JurnalDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateNoJurnal()
    {
        $year = date('Y');
        $month = date('m');
        
        $lastJurnal = self::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->latest('id')
            ->first();
        
        if ($lastJurnal) {
            $lastNumber = intval(substr($lastJurnal->no_jurnal, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'JU' . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function getTotalDebitAttribute()
    {
        return $this->details->sum('debit');
    }

    public function getTotalKreditAttribute()
    {
        return $this->details->sum('kredit');
    }
}