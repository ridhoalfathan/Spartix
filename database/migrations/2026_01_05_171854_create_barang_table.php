<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('kategori'); // Changed from enum to string
            $table->string('merk');
            $table->decimal('harga', 15, 2)->default(0); // New field
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(5);
            $table->enum('metode', ['FIFO'])->default('FIFO');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};