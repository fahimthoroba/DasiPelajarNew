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
        Schema::create('absensi_records', function (Blueprint $table) {
            $table->id();

            $table->string('absensi_id');
            $table->foreign('absensi_id')->references('id')->on('absensis')->cascadeOnDelete();

            $table->string('kader_id');
            $table->foreign('kader_id')->references('id')->on('kaders')->cascadeOnDelete();
            $table->enum('status_kehadiran', ['hadir', 'izin', 'sakit', 'alpha']);
            $table->dateTime('waktu_hadir');
            $table->text('keterangan')->nullable();
            $table->string('bukti_foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_records');
    }
};
