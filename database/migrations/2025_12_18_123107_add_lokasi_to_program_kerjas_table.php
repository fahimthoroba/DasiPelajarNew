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
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('tgl_pelaksanaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('program_kerjas', 'lokasi')) {
            Schema::table('program_kerjas', function (Blueprint $table) {
                $table->dropColumn('lokasi');
            });
        }
    }
};
