<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('id_karyawan')->unique();
            $table->string('nama_karyawan');
            $table->enum('jabatan', ['Admin', 'Produksi', 'Packing', 'Pengirim', 'Finishing']);
            $table->enum('kategori', ['Mencatat Laporan', 'Besar', 'Sedang', 'Kecil']);
            $table->string('hasil')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};