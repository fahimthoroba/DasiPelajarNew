<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->string('kader_id');
            $table->foreign('kader_id')->references('id')->on('kaders')->cascadeOnDelete();
            $table->string('nama_pelatihan'); // Makesta, Lakmud, Diklatama
            $table->enum('jenis', ['Formal', 'Non-Formal']);
            $table->string('penyelenggara'); // Misal: PAC Ngasem
            $table->year('tahun');
            $table->string('lokasi')->nullable();
            $table->string('nomor_sertifikat')->nullable();
            $table->timestamps();
        });
    }
};
