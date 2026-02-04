<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('program_kerjas', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama_proker');
            $table->string('departemen_id'); // Foreign Key to departemens.id (string)
            $table->date('tgl_pelaksanaan');
            $table->string('penanggung_jawab')->nullable(); // Optional person name

            // Update: Kolom LPJ
            $table->string('path_lpj')->nullable(); // Lokasi file PDF
            $table->enum('status_lpj', ['Belum', 'Draft', 'Verified'])->default('Belum');

            $table->timestamps();
        });
    }
};
