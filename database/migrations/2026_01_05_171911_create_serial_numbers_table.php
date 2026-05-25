<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
            $table->foreignId('barang_masuk_id')->constrained('barang_masuk')->onDelete('cascade');
            $table->decimal('harga_beli', 15, 2);
            $table->enum('status', ['READY', 'TERJUAL'])->default('READY');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('serial_numbers');
    }
};