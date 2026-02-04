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
        Schema::create('absensis', function (Blueprint $table) {
            $table->string('id')->primary(); // absXXX
            $table->string('program_kerja_id')->nullable();
            $table->foreign('program_kerja_id')->references('id')->on('program_kerjas')->cascadeOnDelete();

            $table->string('judul');
            $table->enum('jenis', ['rapat', 'kegiatan'])->default('kegiatan');
            $table->text('deskripsi')->nullable();
            $table->dateTime('tgl_waktu');
            $table->string('lokasi')->nullable();

            $table->string('departemen_id')->nullable();
            $table->foreign('departemen_id')->references('id')->on('departemens')->nullOnDelete();

            $table->string('kode_akses')->nullable();
            $table->enum('status', ['buka', 'tutup'])->default('buka');

            $table->string('notulensi_path')->nullable(); // Merged from meetings

            $table->string('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
