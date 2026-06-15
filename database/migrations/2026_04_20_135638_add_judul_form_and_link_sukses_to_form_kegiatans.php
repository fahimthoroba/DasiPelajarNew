<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_kegiatans', function (Blueprint $table) {
            $table->string('judul_form')->nullable()->after('nama_kegiatan');
            $table->string('link_sukses')->nullable()->after('custom_fields');
        });
    }

    public function down(): void
    {
        Schema::table('form_kegiatans', function (Blueprint $table) {
            $table->dropColumn(['judul_form', 'link_sukses']);
        });
    }
};
