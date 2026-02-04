<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_keputusans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sk')->unique(); // Misal: 05/PC/SK/XII/2025
            $table->string('judul_sk'); // Misal: Pengesahan PR IPNU Desa X
            $table->date('tgl_berlaku');
            $table->date('tgl_selesai'); // Kunci penentu Status Aktif/Demisioner
            $table->string('file_sk_path')->nullable(); // Lokasi file PDF
            $table->timestamps();
        });
    }
};
