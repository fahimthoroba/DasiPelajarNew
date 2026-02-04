<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Modify Users Table
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','pengurus','anggota','pers','sekretaris','departemen') DEFAULT 'anggota'");

        Schema::table('users', function (Blueprint $table) {
            $table->string('departemen_id')->nullable()->after('role');
            $table->foreign('departemen_id')->references('id')->on('departemens')->nullOnDelete();
        });

        // 2. Modify Program Kerjas Table
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->enum('status_pelaksanaan', ['Perencanaan', 'Persiapan', 'Pelaksanaan', 'Selesai'])->default('Perencanaan')->after('status_lpj');
            $table->text('deskripsi_kegiatan')->nullable()->after('nama_proker');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert Users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['departemen_id']);
            $table->dropColumn('departemen_id');
        });
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','pengurus','anggota','pers','sekretaris') DEFAULT 'anggota'");

        // Revert Program Kerjas
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->dropColumn(['status_pelaksanaan', 'deskripsi_kegiatan']);
        });
    }
};
