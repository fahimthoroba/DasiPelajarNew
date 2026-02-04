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
        Schema::table('pengaturan_webs', function (Blueprint $table) {
            $table->string('header_news_title')->nullable()->default('Suara Pelajar Kediri');
            $table->text('header_news_desc')->nullable()->default('Informasi terkini kegiatan, opini, dan pergerakan pelajar NU di Kabupaten Kediri.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_webs', function (Blueprint $table) {
            $table->dropColumn(['header_news_title', 'header_news_desc']);
        });
    }
};
