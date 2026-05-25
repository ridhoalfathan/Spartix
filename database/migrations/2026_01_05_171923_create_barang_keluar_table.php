<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->index(); // Hapus unique(), tambah index()
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
            $table->foreignId('serial_number_id')->constrained('serial_numbers')->onDelete('cascade');
            $table->decimal('hpp', 15, 2);
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('laba', 15, 2);
            $table->date('tanggal_keluar');
            $table->string('customer')->nullable();
            $table->string('metode_pembayaran')->default('tunai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};