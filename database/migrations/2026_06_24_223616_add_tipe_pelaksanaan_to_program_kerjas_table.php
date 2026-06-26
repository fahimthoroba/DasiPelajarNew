<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->enum('tipe_pelaksanaan', ['kepanitiaan', 'penanggung_jawab'])
                  ->default('kepanitiaan')
                  ->after('penanggung_jawab');
            $table->string('penanggung_jawab_pengurus_id')->nullable()->after('tipe_pelaksanaan');
            $table->foreign('penanggung_jawab_pengurus_id')->references('id')->on('pengurus')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->dropForeign(['penanggung_jawab_pengurus_id']);
            $table->dropColumn(['tipe_pelaksanaan', 'penanggung_jawab_pengurus_id']);
        });
    }
};
