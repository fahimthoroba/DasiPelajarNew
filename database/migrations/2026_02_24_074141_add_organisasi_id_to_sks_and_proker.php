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
        // 1. Update Surat Keputusan
        Schema::table('surat_keputusans', function (Blueprint $table) {
            $table->foreignId('organisasi_id')->nullable()->after('id')->constrained('organisasis')->cascadeOnDelete();
        });

        // 2. Update Master Proker (Kategori Program)
        Schema::table('kategori_program', function (Blueprint $table) {
            // Drop old user reference if it exists
            if (Schema::hasColumn('kategori_program', 'dibuat_oleh_pac_id')) {
                $table->dropForeign(['dibuat_oleh_pac_id']);
                $table->dropColumn('dibuat_oleh_pac_id');
            }
            
            // Add new organisasi reference
            $table->foreignId('organisasi_id')->nullable()->after('departemen_id')->constrained('organisasis')->nullOnDelete();
        });

        // 3. Update Realisasi Proker
        Schema::table('realisasi_program', function (Blueprint $table) {
            // Drop old user reference if it exists
            if (Schema::hasColumn('realisasi_program', 'pac_id')) {
                $table->dropForeign(['pac_id']);
                $table->dropColumn('pac_id');
            }

            // Add new organisasi reference
            $table->foreignId('organisasi_id')->nullable()->after('id')->constrained('organisasis')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_keputusans', function (Blueprint $table) {
            $table->dropForeign(['organisasi_id']);
            $table->dropColumn('organisasi_id');
        });

        Schema::table('kategori_program', function (Blueprint $table) {
             $table->dropForeign(['organisasi_id']);
             $table->dropColumn('organisasi_id');
             
             $table->string('dibuat_oleh_pac_id')->nullable();
        });

        Schema::table('realisasi_program', function (Blueprint $table) {
             $table->dropForeign(['organisasi_id']);
             $table->dropColumn('organisasi_id');

             $table->string('pac_id')->nullable();
        });
    }
};
