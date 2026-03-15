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
        if (!Schema::hasTable('peserta_kegiatans')) {
            Schema::create('peserta_kegiatans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('form_kegiatan_id')->constrained('form_kegiatans')->cascadeOnDelete();
                $table->string('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
                $table->string('nama_lengkap');
                $table->string('jenis_kelamin', 10)->nullable();
                $table->string('no_wa')->nullable();
                $table->string('asal_instansi')->nullable();
                $table->json('custom_answers')->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected', 'attended'])->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_kegiatans');
    }
};
