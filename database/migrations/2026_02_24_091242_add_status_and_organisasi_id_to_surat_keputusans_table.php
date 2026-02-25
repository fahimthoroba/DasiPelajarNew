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
        Schema::table('surat_keputusans', function (Blueprint $table) {
            $table->string('status')->default('Aktif')->comment('Draft, Menunggu Pengesahan PC, Aktif, Demisioner, Ditolak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_keputusans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
