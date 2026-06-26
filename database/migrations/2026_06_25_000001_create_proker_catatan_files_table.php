<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proker_catatan_files', function (Blueprint $table) {
            $table->id();
            $table->string('program_kerja_id');
            $table->foreign('program_kerja_id')->references('id')->on('program_kerjas')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('keterangan')->nullable();
            $table->string('uploaded_by')->nullable();
            $table->foreign('uploaded_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
            // Sengaja tidak ada endpoint hapus — append-only, beda dari lpj_revisions (tidak ada status verifikasi)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proker_catatan_files');
    }
};
