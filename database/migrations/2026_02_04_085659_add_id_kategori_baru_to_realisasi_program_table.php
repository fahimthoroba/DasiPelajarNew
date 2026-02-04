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
        Schema::table('realisasi_program', function (Blueprint $table) {
            $table->integer('id_kategori_baru')->nullable()->default(null)->after('kategori_program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('realisasi_program', function (Blueprint $table) {
            $table->dropColumn('id_kategori_baru');
        });
    }
};
