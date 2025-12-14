<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('id_pembelian')->unique();
            $table->string('nama_supplier');
            $table->decimal('total_pembelian', 15, 2);
            $table->date('tanggal_pembelian');
            $table->enum('status', ['Complete', 'Pending', 'Cancelled'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};