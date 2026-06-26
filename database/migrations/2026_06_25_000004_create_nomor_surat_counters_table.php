<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nomor_surat_counters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisasi_id')->constrained();
            $table->enum('jenis_organisasi', ['IPNU', 'IPPNU']);
            $table->foreignId('periode_kepengurusan_id')->constrained();
            $table->unsignedInteger('nomor_terakhir')->default(0);
            $table->timestamps();
            $table->unique(['organisasi_id', 'jenis_organisasi', 'periode_kepengurusan_id'], 'nsc_org_jenis_periode_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomor_surat_counters');
    }
};
