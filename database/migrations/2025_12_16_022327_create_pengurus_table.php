<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengurus', function (Blueprint $table) {
            $table->string('id')->primary();

            // Relasi ke Tabel Kader
            $table->string('kader_id');
            $table->foreign('kader_id')->references('id')->on('kaders')->cascadeOnDelete();

            // Relasi ke Tabel SK
            $table->foreignId('surat_keputusan_id')->constrained('surat_keputusans')->cascadeOnDelete();

            // Detail Jabatan
            $table->enum('tingkatan', ['Cabang', 'Anak Cabang', 'Ranting', 'Komisariat']);
            $table->string('nama_tingkatan'); // Misal: "Kecamatan Mojo" atau "Desa Ngadi"
            $table->string('jabatan'); // Misal: "Ketua", "Wakil Sekretaris"
            $table->string('departemen')->nullable(); // Misal: "Departemen Kaderisasi" (Boleh kosong jika Ketua)

            $table->timestamps();
        });
    }
};
