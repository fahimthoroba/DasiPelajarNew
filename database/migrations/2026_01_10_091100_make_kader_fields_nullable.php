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
        Schema::table('kaders', function (Blueprint $table) {
            $table->string('nik')->nullable()->change();
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tgl_lahir')->nullable()->change();
            $table->string('desa')->nullable()->change();
            $table->string('kecamatan')->nullable()->change();
            $table->string('kabupaten')->default('Kediri')->nullable()->change();
            $table->string('no_hp')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kaders', function (Blueprint $table) {
            $table->string('nik')->nullable(false)->change();
            $table->string('tempat_lahir')->nullable(false)->change();
            $table->date('tgl_lahir')->nullable(false)->change();
            $table->string('desa')->nullable(false)->change();
            $table->string('kecamatan')->nullable(false)->change();
            $table->string('kabupaten')->default('Kediri')->nullable(false)->change();
            $table->string('no_hp')->nullable(false)->change();
        });
    }
};
