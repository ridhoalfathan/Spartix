<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buku_besar', function (Blueprint $table) {
            $table->id();
            
            // Gunakan unsignedBigInteger untuk foreign key
            $table->unsignedBigInteger('jurnal_umum_id');
            
            $table->string('nama_akun'); // Kas, Pendapatan Usaha, Beban Gaji
            $table->date('tanggal');
            $table->text('keterangan');
            $table->string('no_referensi')->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('kredit', 15, 2)->default(0);
            $table->decimal('saldo', 15, 2)->default(0);
            $table->timestamps();
            
            // Foreign key constraint - PERBAIKI NAMA TABEL
            $table->foreign('jurnal_umum_id')
                  ->references('id')
                  ->on('jurnal_umums')  // ✅ Ubah dari 'jurnal_umum' ke 'jurnal_umums'
                  ->onDelete('cascade');
            
            $table->index(['nama_akun', 'tanggal']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku_besar');
    }
};