<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu');
            $table->integer('quantity')->default(0); // Jumlah yang diproduksi
            $table->enum('status', [
                'Selesai', 
                'Belum Diproses', 
                'Sedang Diproses', 
                'Dibatalkan', 
                'Proses', 
                'Menunggu Bahan'
            ])->default('Belum Diproses');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};