<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('surat_keluars', function (Blueprint $table) {
            $table->foreignId('organisasi_id')->nullable()->after('id')->constrained();
            $table->enum('jenis_surat', ['reguler', 'bersama', 'kepanitiaan', 'kepanitiaan_bersama'])
                  ->default('reguler')->after('organisasi_id');
            $table->string('jenis_organisasi')->nullable()->after('jenis_surat'); // IPNU/IPPNU, null jika bersama/kepanitiaan_bersama
            $table->string('kode_indeks')->nullable();
            $table->string('program_kerja_id')->nullable();
            $table->foreign('program_kerja_id')->references('id')->on('program_kerjas')->nullOnDelete();
            $table->string('nama_kepanitiaan')->nullable(); // cached dari program_kerjas.kode_surat_kepanitiaan
            $table->unsignedInteger('nomor_urut')->nullable();
            $table->unsignedInteger('nomor_urut_pasangan')->nullable();
            $table->enum('status_arsip', ['nomor_terbit', 'lengkap'])->default('nomor_terbit');
        });

        // Backfill data lama (kalau ada): sudah final, anggap 'reguler' + 'lengkap'
        // (tidak dalam status "nomor terbit belum lengkap" karena dibuat sebelum alur 2-fase ini ada)
        DB::table('surat_keluars')->update([
            'jenis_surat' => 'reguler',
            'status_arsip' => 'lengkap',
        ]);
    }

    public function down(): void
    {
        Schema::table('surat_keluars', function (Blueprint $table) {
            $table->dropForeign(['organisasi_id']);
            $table->dropForeign(['program_kerja_id']);
            $table->dropColumn([
                'organisasi_id', 'jenis_surat', 'jenis_organisasi', 'kode_indeks',
                'program_kerja_id', 'nama_kepanitiaan', 'nomor_urut', 'nomor_urut_pasangan', 'status_arsip',
            ]);
        });
    }
};
