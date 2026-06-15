<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom baru di tabel beritas
        Schema::table('beritas', function (Blueprint $table) {
            $table->text('ringkasan')->nullable()->after('konten');
            $table->boolean('is_headline')->default(false)->after('status');
            $table->enum('jenis', ['berita', 'opini', 'pengumuman', 'foto'])->default('berita')->after('kategori_berita_id');
            $table->string('sumber')->nullable()->after('views');
        });

        // 2. Tabel tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('slug', 100)->unique();
            $table->timestamps();
        });

        // 3. Tabel pivot berita_tag
        Schema::create('berita_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('berita_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('berita_id')->references('id')->on('beritas')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            $table->primary(['berita_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_tag');
        Schema::dropIfExists('tags');

        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn(['ringkasan', 'is_headline', 'jenis', 'sumber']);
        });
    }
};
