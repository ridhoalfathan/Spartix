<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        
        // Buat tabel baru yang clean
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('id_karyawan')->unique();
            $table->string('nama_karyawan');
            $table->enum('jabatan', ['Admin', 'Produksi', 'Packing', 'Pengirim', 'Finishing']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};