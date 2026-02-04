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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kode_barang');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat']);
            $table->date('tgl_pengadaan');
            $table->string('sumber_dana')->nullable();
            $table->string('lokasi');
            $table->string('foto_barang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
