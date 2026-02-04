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
        Schema::create('pengaturan_webs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_website')->default('PC IPNU IPPNU Kediri');
            $table->text('deskripsi_singkat')->nullable();
            $table->string('logo_path')->nullable();

            // Kontak & Sosmed
            $table->string('email')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('alamat')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_webs');
    }
};
