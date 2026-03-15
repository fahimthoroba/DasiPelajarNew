<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('form_kegiatans')) {
            Schema::create('form_kegiatans', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kegiatan');
                $table->unsignedBigInteger('organisasi_id')->nullable();
                $table->foreign('organisasi_id')->references('id')->on('organisasis')->nullOnDelete();
                $table->string('slug')->unique(); // Unique public URL
                $table->boolean('is_open')->default(true);
                $table->dateTime('tgl_buka')->nullable();
                $table->dateTime('tgl_tutup')->nullable();
                $table->json('custom_fields')->nullable(); // Stores [{name, label, type, required}]
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_kegiatans');
    }
};
