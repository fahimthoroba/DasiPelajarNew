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
        // 1. Modifikasi tabel users
        // Karena MariaDB tidak support DDL di dalam transaksi dengan sempurna,
        // ada kemungkinan kolom sudah terhapus di percobaan sebelumnya.
        if (Schema::hasColumn('users', 'alamat_sekretariat')) {
            Schema::table('users', function (Blueprint $table) {
                // Drop kolom milik pac (sudah dipindah ke tabel organisasi)
                $table->dropColumn([
                    'alamat_sekretariat', 
                    'zona_wilayah', 
                    'nomor_sp', 
                    'masa_khidmat_mulai', 
                    'masa_khidmat_selesai',
                    'departemen_id' 
                ]);
            });
        }

        // 2. Modifikasi tabel pengurus
        if (!Schema::hasColumn('pengurus', 'organisasi_id')) {
            Schema::table('pengurus', function (Blueprint $table) {
                $table->foreignId('organisasi_id')->nullable()->after('kader_id')->constrained('organisasis')->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('pengurus', 'is_active')) {
            Schema::table('pengurus', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('departemen_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
            $table->dropForeign(['organisasi_id']);
            $table->dropColumn(['organisasi_id', 'is_active']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('alamat_sekretariat')->nullable();
            $table->string('zona_wilayah')->nullable();
            $table->string('nomor_sp')->nullable();
            $table->date('masa_khidmat_mulai')->nullable();
            $table->date('masa_khidmat_selesai')->nullable();
            
            $table->string('departemen_id')->nullable();
            $table->foreign('departemen_id')->references('id')->on('departemens')->nullOnDelete();
        });
    }
};
