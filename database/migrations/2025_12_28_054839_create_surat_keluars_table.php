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
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat');
            $table->string('departemen_id')->nullable();
            $table->foreign('departemen_id')->references('id')->on('departemens')->nullOnDelete();
            $table->string('tujuan');
            $table->string('perihal');
            $table->date('tgl_surat');
            $table->string('file_arsip')->nullable();
            $table->string('pembuat_id');
            $table->foreign('pembuat_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
