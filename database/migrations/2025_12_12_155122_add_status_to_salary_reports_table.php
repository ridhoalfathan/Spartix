<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('salary_reports', function (Blueprint $table) {
            // Tambahkan kolom status jika belum ada
            if (!Schema::hasColumn('salary_reports', 'status')) {
                $table->enum('status', ['pending', 'paid', 'cancelled'])
                      ->default('pending')
                      ->after('total'); // sesuaikan posisi kolom
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salary_reports', function (Blueprint $table) {
            if (Schema::hasColumn('salary_reports', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};