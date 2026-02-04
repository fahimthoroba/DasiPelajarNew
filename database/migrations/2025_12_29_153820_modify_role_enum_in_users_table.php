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
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','pengurus','anggota','pers','sekretaris') DEFAULT 'anggota'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum (warning: data loss if 'sekretaris' exists)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','pengurus','anggota','pers') DEFAULT 'anggota'");
    }
};
