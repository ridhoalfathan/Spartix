<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('id_pesanan')->unique();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('nama_pemesan');
            $table->integer('jumlah_pesanan');
            $table->date('tanggal_pembayaran');
            $table->enum('status', ['Complete', 'Pending'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};