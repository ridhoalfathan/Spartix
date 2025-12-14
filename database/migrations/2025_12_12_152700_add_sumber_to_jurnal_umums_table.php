<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurnal_umums', function (Blueprint $table) {
            // Tambah kolom untuk tracking sumber data
            $table->string('sumber_transaksi')->nullable()->after('kredit'); // pembelian, transaksi, salary_report, manual
            $table->unsignedBigInteger('sumber_id')->nullable()->after('sumber_transaksi');
            $table->string('no_referensi')->nullable()->after('sumber_id');
        });
    }

    public function down(): void
    {
        Schema::table('jurnal_umums', function (Blueprint $table) {
            $table->dropColumn(['sumber_transaksi', 'sumber_id', 'no_referensi']);
        });
    }
};