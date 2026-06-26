<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('periode_kepengurusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisasi_id')->constrained();
            $table->enum('jenis_organisasi', ['IPNU', 'IPPNU']);
            $table->unsignedSmallInteger('periode_ke'); // simpan integer, format ke romawi saat render
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_kepengurusans');
    }
};
