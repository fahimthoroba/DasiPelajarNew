<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departemens', function (Blueprint $table) {
            $table->enum('jenis', ['departemen', 'lembaga', 'badan'])->default('departemen')->after('nama_departemen');
        });

        // Set jenis berdasarkan ID yang sudah ada di database
        $lembagaIds = ['dep013', 'dep014', 'dep015', 'dep016', 'dep017', 'dep020', 'dep021', 'dep022', 'dep023', 'dep024'];
        $badanIds   = ['dep018', 'dep019'];

        DB::table('departemens')->whereIn('id', $lembagaIds)->update(['jenis' => 'lembaga']);
        DB::table('departemens')->whereIn('id', $badanIds)->update(['jenis' => 'badan']);
    }

    public function down(): void
    {
        Schema::table('departemens', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
    }
};
