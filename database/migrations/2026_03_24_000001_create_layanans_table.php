<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', [
                'Template Surat',
                'Pedoman',
                'Peraturan',
                'Formulir',
                'Doa & Dzikir',
                'Lainnya',
            ]);
            $table->string('file_path');
            $table->string('ukuran_file')->nullable();
            $table->unsignedBigInteger('jumlah_download')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
