<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nomor_surat_kepanitiaan_counters', function (Blueprint $table) {
            $table->id();
            $table->string('program_kerja_id');
            $table->foreign('program_kerja_id')->references('id')->on('program_kerjas')->cascadeOnDelete();
            $table->enum('jenis_organisasi', ['IPNU', 'IPPNU', 'Bersama']);
            $table->unsignedInteger('nomor_terakhir')->default(0);
            $table->timestamps();
            $table->unique(['program_kerja_id', 'jenis_organisasi'], 'nskc_proker_jenis_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomor_surat_kepanitiaan_counters');
    }
};
