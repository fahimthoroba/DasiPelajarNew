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
        Schema::create('komentar_beritas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('berita_id');
            $table->string('nama');
            $table->string('email')->nullable();
            $table->text('konten');
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('berita_id')->references('id')->on('beritas')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('komentar_beritas')->onDelete('cascade');
            $table->index(['berita_id', 'is_approved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_beritas');
    }
};
