<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Enhance absensis table
        // Step A: expand enum to include both old + new values
        DB::statement("ALTER TABLE absensis MODIFY COLUMN jenis ENUM('rapat','kegiatan','rapat_rutin','rapat_departemen','rapat_panitia','pelaksanaan','rapat_pac','rapat_lembaga','rapat_badan') DEFAULT 'rapat_departemen'");
        // Step B: migrate old data
        DB::table('absensis')->where('jenis', 'rapat')->update(['jenis' => 'rapat_rutin']);
        DB::table('absensis')->where('jenis', 'kegiatan')->update(['jenis' => 'pelaksanaan']);
        // Step C: shrink enum to only new values
        DB::statement("ALTER TABLE absensis MODIFY COLUMN jenis ENUM('rapat_rutin','rapat_departemen','rapat_panitia','pelaksanaan','rapat_pac','rapat_lembaga','rapat_badan') DEFAULT 'rapat_departemen'");

        Schema::table('absensis', function (Blueprint $table) {
            $table->unsignedBigInteger('organisasi_id')->nullable()->after('departemen_id');
            $table->foreign('organisasi_id')->references('id')->on('organisasis')->nullOnDelete();
            $table->timestamp('closed_at')->nullable()->after('status');
        });

        // 2. Enhance absensi_records table
        // Make kader_id nullable to support non-kader attendees
        DB::statement("ALTER TABLE absensi_records MODIFY COLUMN kader_id VARCHAR(255) NULL");
        // Drop existing foreign key first, then re-add with nullOnDelete
        Schema::table('absensi_records', function (Blueprint $table) {
            $table->dropForeign(['kader_id']);
        });
        Schema::table('absensi_records', function (Blueprint $table) {
            $table->foreign('kader_id')->references('id')->on('kaders')->nullOnDelete();
            $table->string('nama_peserta')->nullable()->after('kader_id');
            $table->enum('tipe_peserta', ['kader', 'umum'])->default('kader')->after('nama_peserta');
            $table->enum('metode', ['scan', 'manual'])->default('scan')->after('tipe_peserta');
        });

        // 3. Fix kepanitiaans — make kader_id nullable + add nama_manual
        DB::statement("ALTER TABLE kepanitiaans MODIFY COLUMN kader_id VARCHAR(255) NULL");
        Schema::table('kepanitiaans', function (Blueprint $table) {
            $table->dropForeign(['kader_id']);
        });
        Schema::table('kepanitiaans', function (Blueprint $table) {
            $table->foreign('kader_id')->references('id')->on('kaders')->nullOnDelete();
            $table->string('nama_manual')->nullable()->after('kader_id');
        });
    }

    public function down(): void
    {
        // Revert kepanitiaans
        Schema::table('kepanitiaans', function (Blueprint $table) {
            $table->dropColumn('nama_manual');
            $table->dropForeign(['kader_id']);
        });
        DB::statement("ALTER TABLE kepanitiaans MODIFY COLUMN kader_id VARCHAR(255) NOT NULL");
        Schema::table('kepanitiaans', function (Blueprint $table) {
            $table->foreign('kader_id')->references('id')->on('kaders')->cascadeOnDelete();
        });

        // Revert absensi_records
        Schema::table('absensi_records', function (Blueprint $table) {
            $table->dropColumn(['nama_peserta', 'tipe_peserta', 'metode']);
            $table->dropForeign(['kader_id']);
        });
        DB::statement("ALTER TABLE absensi_records MODIFY COLUMN kader_id VARCHAR(255) NOT NULL");
        Schema::table('absensi_records', function (Blueprint $table) {
            $table->foreign('kader_id')->references('id')->on('kaders')->cascadeOnDelete();
        });

        // Revert absensis
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['organisasi_id']);
            $table->dropColumn(['organisasi_id', 'closed_at']);
        });
        DB::statement("ALTER TABLE absensis MODIFY COLUMN jenis ENUM('rapat','kegiatan') DEFAULT 'kegiatan'");
    }
};
