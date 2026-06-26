<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            // Diisi manual oleh panitia saat Step 1 (bentuk kepanitiaan), contoh: "MAKESTA"
            // Ditaruh di program_kerjas (bukan kepanitiaans) karena kode_surat adalah properti
            // kepanitiaan-sebagai-satu-kesatuan per proker, bukan per-anggota-panitia —
            // tabel kepanitiaans adalah 1 row PER ANGGOTA (kader_id+jabatan) dan di-delete+recreate
            // penuh setiap bulkStorePanitia(), sehingga tidak cocok jadi tempat field ini.
            $table->string('kode_surat_kepanitiaan')->nullable()->after('tipe_pelaksanaan');
        });
    }

    public function down(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->dropColumn('kode_surat_kepanitiaan');
        });
    }
};
