<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramKerja;
use Carbon\Carbon;

class ProgramKerjaSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate to reset
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProgramKerja::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ProgramKerja::create([
            'nama_proker' => 'MAKESTA Raya 2025',
            'tgl_pelaksanaan' => Carbon::now()->addDays(5),
            'penanggung_jawab' => 'Departemen Kaderisasi',
            'status_lpj' => 'Belum',
            'lokasi' => 'Ponpes Lirboyo',
        ]);

        ProgramKerja::create([
            'nama_proker' => 'Konferensi Cabang (KONFERCAB)',
            'tgl_pelaksanaan' => Carbon::now()->addDays(20),
            'penanggung_jawab' => 'Sekretaris',
            'status_lpj' => 'Belum',
            'lokasi' => 'Gedung PCNU Kediri',
        ]);

        ProgramKerja::create([
            'nama_proker' => 'Latihan Kader Muda (LAKMUD)',
            'tgl_pelaksanaan' => Carbon::now()->addMonths(2),
            'penanggung_jawab' => 'Wakil Ketua I',
            'status_lpj' => 'Belum',
            'lokasi' => 'Kecamatan Pare',
        ]);

        ProgramKerja::create([
            'nama_proker' => 'Festival Sholawat Pelajar',
            'tgl_pelaksanaan' => Carbon::now()->addMonths(3),
            'penanggung_jawab' => 'Lembaga Seni Budaya',
            'status_lpj' => 'Belum',
            'lokasi' => 'Simpang Lima Gumul',
        ]);
    }
}
