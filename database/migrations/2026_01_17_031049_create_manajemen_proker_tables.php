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
        // 1. Tabel Kategori Program (Master)
        Schema::create('kategori_program', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori')->unique();
            $table->string('slug')->unique();

            // Perbaikan: ID Departemen & User bertipe String
            $table->string('departemen_id');
            $table->foreign('departemen_id')->references('id')->on('departemens')->cascadeOnDelete();

            // Nullable: Jika null berarti dibuat oleh Admin PC. Jika ada isinya berarti usulan PAC.
            $table->string('dibuat_oleh_pac_id')->nullable();
            $table->foreign('dibuat_oleh_pac_id')->references('id')->on('users')->nullOnDelete();

            // Status verifikasi: Kategori dari PAC perlu diverifikasi PC sebelum muncul di semua user.
            // Kategori dari PC otomatis true.
            $table->boolean('status_verifikasi')->default(false);

            $table->timestamps();
        });

        // 2. Tabel Realisasi Program (Kegiatan PAC)
        Schema::create('realisasi_program', function (Blueprint $table) {
            $table->id();

            // Perbaikan: ID User bertipe String
            $table->string('pac_id');
            $table->foreign('pac_id')->references('id')->on('users')->cascadeOnDelete();

            $table->foreignId('kategori_program_id')->constrained('kategori_program')->cascadeOnDelete();

            $table->string('nama_lokal'); // Nama unik kreasi PAC
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');

            $table->enum('status', ['Rencana', 'Pasti', 'Terlaksana'])->default('Rencana');
            $table->boolean('is_fix')->default(false); // Terkunci jadwalnya

            // Target peserta bisa multiple, simpan sebagai JSON
            // Contoh options: Internal PAC, Ranting, Pelajar Umum, Masyarakat, Banom Lain
            $table->json('target_peserta')->nullable();

            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 3. Update Tabel Users untuk Profil PAC
        Schema::table('users', function (Blueprint $table) {
            $table->string('alamat_sekretariat')->nullable()->after('departemen_id');
            $table->string('zona_wilayah')->nullable()->after('alamat_sekretariat');
            // Tambahan: Data Surat Pengesahan (SP)
            $table->string('nomor_sp')->nullable()->after('zona_wilayah');
            $table->date('masa_khidmat_mulai')->nullable()->after('nomor_sp');
            $table->date('masa_khidmat_selesai')->nullable()->after('masa_khidmat_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'alamat_sekretariat',
                'zona_wilayah',
                'nomor_sp',
                'masa_khidmat_mulai',
                'masa_khidmat_selesai'
            ]);
        });

        Schema::dropIfExists('realisasi_program');
        Schema::dropIfExists('kategori_program');
    }
};
