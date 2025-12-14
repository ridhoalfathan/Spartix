<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('gaji_per_jam', 15, 2); // Gaji per jam
            $table->decimal('lama_bekerja', 8, 2); // Lama bekerja dalam jam (bisa desimal, misal 1.5 jam)
            $table->decimal('bonus', 15, 2)->default(0);
            $table->decimal('total', 15, 2); // (gaji_per_jam x lama_bekerja) + bonus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_reports');
    }
};