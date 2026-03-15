<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','pengurus','anggota','pers','sekretaris','departemen','pac','dep_organisasi','dep_kaderisasi') DEFAULT 'anggota'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','pengurus','anggota','pers','sekretaris','departemen','pac','dep_organisasi') DEFAULT 'anggota'");
    }
};
