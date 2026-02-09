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
            // Mandikan agar nullable dan punya default null untuk menghindari error "doesn't have a default value"
            $table->integer('id_kategori_baru')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('realisasi_program', function (Blueprint $table) {
            // Revert jika diperlukan, tapi biasanya dibiarkan nullable aman
        });
    }
};
