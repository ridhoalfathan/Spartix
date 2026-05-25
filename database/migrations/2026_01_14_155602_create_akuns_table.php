<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akuns', function (Blueprint $table) {
            $table->id();
            $table->string('kode_akun', 20)->unique();
            $table->string('nama_akun');
            $table->enum('tipe_akun', ['Aset', 'Liabilitas', 'Ekuitas', 'Pendapatan', 'Beban']);
            $table->enum('kategori', ['Lancar', 'Tidak Lancar', 'Operasional', 'Non-Operasional'])->nullable();
            $table->decimal('saldo_normal', 20, 2)->default(0);
            $table->enum('posisi_normal', ['Debit', 'Kredit']);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('akuns')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akuns');
    }
};
