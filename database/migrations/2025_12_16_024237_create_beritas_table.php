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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_berita_id')->constrained('kategori_beritas')->cascadeOnDelete();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete(); // Penulis
            $table->string('judul');
            $table->string('slug')->unique(); // URL cantik
            $table->string('thumbnail')->nullable();
            $table->text('konten'); // Isi berita
            $table->enum('status', ['Draft', 'Published'])->default('Draft');
            $table->date('tgl_publish')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
