<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1 PC
        \Illuminate\Support\Facades\DB::table('organisasis')->insert([
            'nama' => 'PC IPNU IPPNU Kabupaten Kediri', 'tingkat' => 'PC',
            'parent_id' => null, 'zona_wilayah' => 'Kediri',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $pcId = \Illuminate\Support\Facades\DB::getPdo()->lastInsertId();

        // 26 PAC (Kecamatan se-Kabupaten Kediri)
        $kecamatans = [
            'Badas', 'Banyakan', 'Gampengrejo', 'Grogol', 'Gurah',
            'Kandangan', 'Kandat', 'Kayen Kidul', 'Kepung', 'Kras',
            'Kunjang', 'Mojo', 'Ngadiluwih', 'Ngancar', 'Pagu',
            'Papar', 'Pare', 'Plemahan', 'Plosoklaten', 'Puncu',
            'Purwoasri', 'Ringinrejo', 'Semen', 'Tarokan', 'Wates',
            'Kasembon',
        ];

        $pacIds = [];
        foreach ($kecamatans as $kec) {
            \Illuminate\Support\Facades\DB::table('organisasis')->insert([
                'nama' => 'PAC IPNU IPPNU ' . $kec, 'tingkat' => 'PAC',
                'parent_id' => $pcId, 'zona_wilayah' => $kec,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $pacIds[$kec] = \Illuminate\Support\Facades\DB::getPdo()->lastInsertId();
        }

        // 30 PR (Ranting contoh, tersebar di beberapa PAC)
        $rantings = [
            ['Desa Paron', 'Ngadiluwih'], ['Desa Bedali', 'Ngancar'],
            ['Desa Purwoasri', 'Purwoasri'], ['Desa Bulusari', 'Tarokan'],
            ['Desa Kras', 'Kras'], ['Desa Purworejo', 'Kandat'],
            ['Desa Papar', 'Papar'], ['Desa Wates', 'Wates'],
            ['Desa Semen', 'Semen'], ['Desa Kepung', 'Kepung'],
            ['Desa Gurah', 'Gurah'], ['Desa Grogol', 'Grogol'],
            ['Desa Badas', 'Badas'], ['Desa Pare', 'Pare'],
            ['Desa Kandangan', 'Kandangan'], ['Desa Plosoklaten', 'Plosoklaten'],
            ['Desa Puncu', 'Puncu'], ['Desa Pagu', 'Pagu'],
            ['Desa Ringinrejo', 'Ringinrejo'], ['Desa Plemahan', 'Plemahan'],
            ['Desa Mojo', 'Mojo'], ['Desa Kunjang', 'Kunjang'],
            ['Desa Gampengrejo', 'Gampengrejo'], ['Desa Kayen Kidul', 'Kayen Kidul'],
            ['Desa Banyakan', 'Banyakan'], ['Desa Kasembon', 'Kasembon'],
            ['Desa Ngancar', 'Ngancar'], ['Desa Tarokan', 'Tarokan'],
            ['Desa Grogol Selatan', 'Grogol'], ['Desa Kepuh Kencono', 'Kepung'],
        ];

        foreach ($rantings as [$nama, $kec]) {
            $parentId = $pacIds[$kec] ?? $pcId;
            \Illuminate\Support\Facades\DB::table('organisasis')->insert([
                'nama' => 'PR IPNU IPPNU ' . $nama, 'tingkat' => 'PR',
                'parent_id' => $parentId, 'zona_wilayah' => $kec,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // 8 PK (Komisariat contoh)
        $pks = [
            ['PK MA Al-Azhar Kediri', 'Pare'],
            ['PK SMA Negeri 1 Pare', 'Pare'],
            ['PK MAN 2 Kediri', 'Gampengrejo'],
            ['PK Ponpes Lirboyo', 'Ngadiluwih'],
            ['PK Ponpes Al-Falah Ploso', 'Mojo'],
            ['PK UNISKA Kediri', 'Grogol'],
            ['PK IAIN Kediri', 'Grogol'],
            ['PK SMK Negeri 2 Kediri', 'Gampengrejo'],
        ];

        foreach ($pks as [$nama, $kec]) {
            $parentId = $pacIds[$kec] ?? $pcId;
            \Illuminate\Support\Facades\DB::table('organisasis')->insert([
                'nama' => $nama, 'tingkat' => 'PK',
                'parent_id' => $parentId, 'zona_wilayah' => $kec,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }
}
