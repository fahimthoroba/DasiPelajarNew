<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lpj_revisions', function (Blueprint $table) {
            $table->id();
            $table->string('program_kerja_id');
            $table->foreign('program_kerja_id')->references('id')->on('program_kerjas')->cascadeOnDelete();
            $table->unsignedInteger('revision_number');
            $table->string('file_path');
            $table->string('submitted_by')->nullable();
            $table->foreign('submitted_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamp('submitted_at');
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->string('reviewed_by')->nullable();
            $table->foreign('reviewed_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lpj_revisions');
    }
};
