<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Langkah 1: Tambah kolom departemen_id jika belum ada
        if (!Schema::hasColumn('users', 'departemen_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('departemen_id', 10)->nullable()->after('role');
                $table->foreign('departemen_id')->references('id')->on('departemens')->nullOnDelete();
            });
        }

        // Langkah 2: Expand role ENUM untuk semua role departemen/lembaga/badan baru
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM(
            'admin','pengurus','anggota','sekretaris','bendahara',
            'dep_organisasi','dep_kaderisasi','dep_jaringan','dep_dakwah','dep_seni','dep_media','dep_pengorg',
            'lmb_lpp','lmb_lekas','lmb_lan','lmb_lkpt','lmb_cbp',
            'lmb_kpp','lmb_konseling','lmb_ekraf','lmb_kdc',
            'bdn_bscc','bdn_bsrc',
            'pac','pr','pk','pk_pt','anggota_biasa',
            'pers','departemen'
        ) NOT NULL DEFAULT 'anggota'");

        // Langkah 3: Update role lama ke role spesifik + set departemen_id
        // use002 mungkin sudah terupdate dari run sebelumnya, skip jika sudah
        DB::table('users')->where('id', 'use002')->where('role', 'departemen')->update([
            'role'          => 'dep_kaderisasi',
            'departemen_id' => 'dep008',
        ]);
        // Pastikan departemen_id use002 sudah benar
        DB::table('users')->where('id', 'use002')->whereNull('departemen_id')->update([
            'departemen_id' => 'dep008',
        ]);

        DB::table('users')->where('id', 'use005')->update([
            'role'          => 'dep_dakwah',
            'departemen_id' => 'dep010',
        ]);
        DB::table('users')->where('id', 'use007')->update([
            'role'          => 'lmb_lpp',
            'departemen_id' => 'dep014',
        ]);
        DB::table('users')->where('id', 'use004')->update([
            'role'          => 'dep_media',
            'departemen_id' => 'dep024',
        ]);
        DB::table('users')->where('id', 'use034')->update([
            'departemen_id' => 'dep007',
        ]);
    }

    public function down(): void
    {
        DB::table('users')->whereIn('id', ['use002', 'use004', 'use005', 'use007'])->update(['role' => 'departemen']);
        DB::table('users')->whereIn('id', ['use002', 'use004', 'use005', 'use007', 'use034'])->update(['departemen_id' => null]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['departemen_id']);
            $table->dropColumn('departemen_id');
        });
    }
};
