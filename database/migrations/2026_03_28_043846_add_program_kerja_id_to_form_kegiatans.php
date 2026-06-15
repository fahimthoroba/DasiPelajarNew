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
        Schema::table('form_kegiatans', function (Blueprint $table) {
            $table->string('program_kerja_id', 10)->nullable()->after('organisasi_id');
            $table->foreign('program_kerja_id')
                  ->references('id')->on('program_kerjas')
                  ->onDelete('set null');
            // nullable unique: NULL boleh duplikat, non-NULL harus unik
            $table->unique('program_kerja_id');
        });
    }

    public function down(): void
    {
        Schema::table('form_kegiatans', function (Blueprint $table) {
            $table->dropForeign(['program_kerja_id']);
            $table->dropUnique(['program_kerja_id']);
            $table->dropColumn('program_kerja_id');
        });
    }
};
