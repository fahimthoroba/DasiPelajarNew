<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organisasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // PC Kediri, PAC Ngasem, PR Sukorejo
            $table->enum('tingkat', ['PC', 'PAC', 'PR', 'PK'])->default('PAC');
            $table->foreignId('parent_id')->nullable()->constrained('organisasis')->nullOnDelete();
            
            // Detail organisasi (dipindah dari tabel users)
            $table->string('alamat_sekretariat')->nullable();
            $table->string('zona_wilayah')->nullable(); // Koordinator zona, jika ada
            $table->string('nomor_sp')->nullable(); // SK/SP Organisasi
            $table->date('masa_khidmat_mulai')->nullable();
            $table->date('masa_khidmat_selesai')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisasis');
    }
};
