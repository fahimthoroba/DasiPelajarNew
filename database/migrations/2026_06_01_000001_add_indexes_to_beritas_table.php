<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->index('status');
            $table->index('tgl_publish');
            $table->index('is_headline');
            $table->index('views');
            $table->index(['status', 'tgl_publish'], 'beritas_status_tgl_publish_index');
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['tgl_publish']);
            $table->dropIndex(['is_headline']);
            $table->dropIndex(['views']);
            $table->dropIndex('beritas_status_tgl_publish_index');
        });
    }
};
