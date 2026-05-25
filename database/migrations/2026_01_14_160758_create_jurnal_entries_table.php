<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jurnal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('no_jurnal')->unique();
            $table->date('tanggal');
            $table->string('referensi')->nullable(); // Referensi ke transaksi lain
            $table->string('referensi_type')->nullable(); // BarangMasuk, BarangKeluar, dll
            $table->text('keterangan');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('jurnal_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jurnal_entry_id');
            $table->unsignedBigInteger('akun_id');
            $table->decimal('debit', 20, 2)->default(0);
            $table->decimal('kredit', 20, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('jurnal_entry_id')->references('id')->on('jurnal_entries')->onDelete('cascade');
            $table->foreign('akun_id')->references('id')->on('akuns')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jurnal_details');
        Schema::dropIfExists('jurnal_entries');
    }
};