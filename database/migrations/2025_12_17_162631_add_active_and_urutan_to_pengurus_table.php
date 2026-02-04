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
        Schema::table('pengurus', function (Blueprint $table) {
            $table->integer('urutan_tampil')->default(99)->after('jabatan');
            $table->boolean('is_active')->default(true)->after('urutan_tampil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
            $table->dropColumn(['urutan_tampil', 'is_active']);
        });
    }
};
