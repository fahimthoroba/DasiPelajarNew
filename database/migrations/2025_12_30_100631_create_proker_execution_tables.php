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
        // 1. Update Program Kerjas (Note: Dropped public registration features)
        Schema::table('program_kerjas', function (Blueprint $table) {
            // No public registration columns needed as per user request
            $table->text('catatan_pelaksanaan')->nullable()->after('status_pelaksanaan');
        });

        // 2. Kepanitiaan (Committee)
        Schema::create('kepanitiaans', function (Blueprint $table) {
            $table->string('id')->primary(); // pntaXXX
            $table->string('program_kerja_id');
            $table->foreign('program_kerja_id')->references('id')->on('program_kerjas')->cascadeOnDelete();

            $table->string('kader_id');
            $table->foreign('kader_id')->references('id')->on('kaders')->cascadeOnDelete();

            $table->string('jabatan'); // e.g., Ketua, Sekretaris
            $table->timestamps();
        });

        // 3. Rundowns REMOVED

        // 4. Pendaftarans (Registrants)
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->string('id')->primary(); // psrtaXXX
            $table->string('program_kerja_id');
            $table->foreign('program_kerja_id')->references('id')->on('program_kerjas')->cascadeOnDelete();

            $table->string('kader_id');
            $table->foreign('kader_id')->references('id')->on('kaders')->cascadeOnDelete();

            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->enum('tipe_daftar', ['internal', 'umum'])->default('internal');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
        // Schema::dropIfExists('rundowns'); // Was removed in up
        Schema::dropIfExists('kepanitiaans');

        Schema::table('program_kerjas', function (Blueprint $table) {
            if (Schema::hasColumn('program_kerjas', 'catatan_pelaksanaan')) {
                $table->dropColumn('catatan_pelaksanaan');
            }
        });
    }
};
