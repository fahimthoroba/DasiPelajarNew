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
        Schema::create('hero_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('judul_utama')->nullable();
            $table->string('sub_judul')->nullable();
            $table->string('gambar_path'); // Wajib ada gambar
            $table->string('link_tombol')->nullable();
            $table->string('teks_tombol')->nullable(); // Misal: "Daftar Sekarang"
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sliders');
    }
};
