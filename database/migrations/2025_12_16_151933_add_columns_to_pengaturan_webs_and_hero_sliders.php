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
            $table->text('profil_singkat')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
        });

        Schema::table('hero_sliders', function (Blueprint $table) {
            $table->boolean('show_button')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_webs', function (Blueprint $table) {
            $table->dropColumn(['profil_singkat', 'visi', 'misi']);
        });

        Schema::table('hero_sliders', function (Blueprint $table) {
            $table->dropColumn('show_button');
        });
    }
};
