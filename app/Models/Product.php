<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'price',
        'image',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Relasi ke Produksi
    public function produksis()
    {
        return $this->hasMany(Produksi::class);
    }

    // Method untuk menambah stok
    public function addStock($quantity)
    {
        $this->increment('stock', $quantity);
    }

    // Method untuk mengurangi stok
    public function reduceStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }
}