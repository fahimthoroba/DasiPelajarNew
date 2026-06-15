<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->unsignedTinyInteger('current_step')->default(1)->after('status_pelaksanaan');
            $table->text('lpj_catatan')->nullable()->after('path_lpj');
            $table->string('verified_by')->nullable()->after('status_lpj');
            $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable()->after('verified_by');
        });
    }

    public function down(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['current_step', 'lpj_catatan', 'verified_by', 'verified_at']);
        });
    }
};
