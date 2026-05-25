<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
            $table->integer('jumlah');
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->date('tanggal_masuk');
            $table->string('supplier')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};