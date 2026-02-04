<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kaders', function (Blueprint $table) {
            $table->string('id')->primary(); // kdr001
            $table->string('nik')->unique(); // Kunci identitas
            $table->string('nama_lengkap');
            $table->string('foto_path')->nullable();

            // Data Kelahiran
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);

            // Alamat Detail (Sesuai Request)
            $table->string('alamat_jalan')->nullable();
            $table->string('dusun')->nullable();
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kabupaten')->default('Kediri');

            $table->string('no_hp');
            $table->timestamps(); // Created_at & Updated_at
        });
    }
};
