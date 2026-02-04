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
        Schema::create('dokumen_arsips', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('kategori', ['sk', 'pedoman', 'undangan', 'lainnya']);
            $table->string('file_path');
            $table->boolean('public')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_managers');
    }
};
