<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nomor_surat_dibatalkan', function (Blueprint $table) {
            $table->id();
            $table->morphs('counter'); // nomor_surat_counters ATAU nomor_surat_kepanitiaan_counters
            $table->unsignedInteger('nomor');
            $table->timestamp('dibatalkan_at');
            $table->string('dibatalkan_by')->nullable();
            $table->foreign('dibatalkan_by')->references('id')->on('users')->nullOnDelete();
            $table->string('alasan')->nullable();
            $table->boolean('sudah_dipakai_ulang')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomor_surat_dibatalkan');
    }
};
