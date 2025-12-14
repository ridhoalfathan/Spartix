<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('jurnal_umums', function (Blueprint $table) {
        $table->string('akun_debit')->nullable();
        $table->string('akun_kredit')->nullable();
    });
}

public function down()
{
    Schema::table('jurnal_umums', function (Blueprint $table) {
        $table->dropColumn('akun_debit');
        $table->dropColumn('akun_kredit');
    });
}

};
