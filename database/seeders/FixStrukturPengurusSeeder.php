<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixStrukturPengurusSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ============================================================
        // PART A: Fix IPPNU existing pengurus (parent_id & departemen_id)
        // ============================================================

        // IPPNU 6 Departemen mapping:
        // dep007 Organisasi (Joint), dep008 Kaderisasi (Joint), dep012 Jarkom (IPPNU)
        // dep010 Dakwah (Joint), dep011 Desbor/Seni Budaya (Joint), dep024 DJSMPP/Media (IPPNU)

        // Fix dep024 jenis: should be 'departemen' not 'lembaga'
        DB::table('departemens')->where('id', 'dep024')->update(['jenis' => 'departemen']);

        // Fix existing IPPNU pengurus parent_id & departemen_id
        $fixes = [
            // Ketua stays root
            'pgr039' => ['parent_id' => null,     'departemen_id' => null],
            // Sekretaris & Bendahara → parent = Ketua
            'pgr044' => ['parent_id' => 'pgr039', 'departemen_id' => null],
            'pgr048' => ['parent_id' => 'pgr039', 'departemen_id' => null],
            // 4 Wakil Ketua → parent = Ketua, each assigned a dept
            'pgr040' => ['parent_id' => 'pgr039', 'departemen_id' => 'dep007'], // Organisasi
            'pgr041' => ['parent_id' => 'pgr039', 'departemen_id' => 'dep008'], // Kaderisasi
            'pgr042' => ['parent_id' => 'pgr039', 'departemen_id' => 'dep012'], // Jarkom
            'pgr043' => ['parent_id' => 'pgr039', 'departemen_id' => 'dep010'], // Dakwah
            // 3 Wakil Sekretaris → parent = Sekretaris
            'pgr045' => ['parent_id' => 'pgr044', 'departemen_id' => 'dep007'], // Organisasi
            'pgr046' => ['parent_id' => 'pgr044', 'departemen_id' => 'dep008'], // Kaderisasi
            'pgr047' => ['parent_id' => 'pgr044', 'departemen_id' => 'dep012'], // Jarkom
            // 2 Wakil Bendahara → parent = Bendahara
            'pgr049' => ['parent_id' => 'pgr048', 'departemen_id' => 'dep007'], // Organisasi
            'pgr050' => ['parent_id' => 'pgr048', 'departemen_id' => 'dep008'], // Kaderisasi
        ];

        foreach ($fixes as $id => $data) {
            DB::table('pengurus')->where('id', $id)->update($data);
        }

        // ============================================================
        // PART B: Create missing IPPNU pengurus + kader
        // ============================================================

        // Dept order: Organisasi(dep007), Kaderisasi(dep008), Jarkom(dep012), Dakwah(dep010), Seni Budaya(dep011), Media(dep024)
        // Waket existing: dep007=pgr040, dep008=pgr041, dep012=pgr042, dep010=pgr043
        // Need: dep011 Waket, dep024 Waket

        $newKaders = [
            // 2 Waket tambahan
            ['id' => 'kdr201', 'nama_lengkap' => 'Siti Nurhaliza',        'quote' => 'Berkarya dalam kebersamaan.'],
            ['id' => 'kdr202', 'nama_lengkap' => 'Fitri Rahmawati',       'quote' => 'Digital untuk dakwah, media untuk umat.'],
            // 3 Wasek tambahan (Dakwah, Seni Budaya, Media)
            ['id' => 'kdr203', 'nama_lengkap' => 'Aisyah Putri Nabila',   'quote' => ''],
            ['id' => 'kdr204', 'nama_lengkap' => 'Dian Safitri',          'quote' => 'Seni adalah ekspresi jiwa.'],
            ['id' => 'kdr205', 'nama_lengkap' => 'Laila Nur Aini',        'quote' => ''],
            // 4 Wabend tambahan (Jarkom, Dakwah, Seni Budaya, Media)
            ['id' => 'kdr206', 'nama_lengkap' => 'Risa Amelia',           'quote' => ''],
            ['id' => 'kdr207', 'nama_lengkap' => 'Intan Permatasari',     'quote' => 'Amanah adalah tanggung jawab.'],
            ['id' => 'kdr208', 'nama_lengkap' => 'Nurul Hidayah',         'quote' => ''],
            ['id' => 'kdr209', 'nama_lengkap' => 'Salsabila Azzahra',     'quote' => ''],
            // 6 Koordinator (1 per dept)
            ['id' => 'kdr210', 'nama_lengkap' => 'Anisa Rahma',           'quote' => 'Organisasi mengajarkan arti tanggung jawab.'],
            ['id' => 'kdr211', 'nama_lengkap' => 'Putri Wulandari',       'quote' => ''],
            ['id' => 'kdr212', 'nama_lengkap' => 'Naila Husna',           'quote' => 'Jaringan yang kuat, organisasi yang kokoh.'],
            ['id' => 'kdr213', 'nama_lengkap' => 'Halimatus Sadiyah',     'quote' => ''],
            ['id' => 'kdr214', 'nama_lengkap' => 'Lutfiana Dewi',         'quote' => 'Seni budaya cerminan peradaban.'],
            ['id' => 'kdr215', 'nama_lengkap' => 'Maharani Putri',        'quote' => ''],
            // 6 Anggota dept
            ['id' => 'kdr216', 'nama_lengkap' => 'Zahra Aulia',           'quote' => ''],
            ['id' => 'kdr217', 'nama_lengkap' => 'Safira Indah',          'quote' => ''],
            ['id' => 'kdr218', 'nama_lengkap' => 'Ayu Lestari',           'quote' => ''],
            ['id' => 'kdr219', 'nama_lengkap' => 'Nadia Fitriana',        'quote' => ''],
            ['id' => 'kdr220', 'nama_lengkap' => 'Bella Oktaviani',       'quote' => ''],
            ['id' => 'kdr221', 'nama_lengkap' => 'Citra Dewi',            'quote' => ''],
            // 4 Lembaga heads
            ['id' => 'kdr222', 'nama_lengkap' => 'Rina Agustina',         'quote' => 'KPP: pelajar putri tangguh dan mandiri.'],
            ['id' => 'kdr223', 'nama_lengkap' => 'Yuni Kartika',          'quote' => 'Mendengarkan adalah kunci konseling.'],
            ['id' => 'kdr224', 'nama_lengkap' => 'Mega Silvia',           'quote' => 'Ekonomi kreatif untuk kemandirian.'],
            ['id' => 'kdr225', 'nama_lengkap' => 'Dewi Lailatul Badriyah','quote' => ''],
            // 4 Anggota lembaga
            ['id' => 'kdr226', 'nama_lengkap' => 'Hana Pertiwi',          'quote' => ''],
            ['id' => 'kdr227', 'nama_lengkap' => 'Sari Melati',           'quote' => ''],
            ['id' => 'kdr228', 'nama_lengkap' => 'Indri Wahyuni',         'quote' => ''],
            ['id' => 'kdr229', 'nama_lengkap' => 'Ratna Sari',            'quote' => ''],
        ];

        foreach ($newKaders as $kader) {
            DB::table('kaders')->insert(array_merge($kader, [
                'nik'          => null,
                'foto_path'    => null,
                'jenis_kelamin'=> 'P',
                'tempat_lahir' => 'Kediri',
                'tgl_lahir'    => null,
                'kabupaten'    => 'Kediri',
                'alamat_jalan' => null,
                'dusun'        => null,
                'desa'         => '-',
                'kecamatan'    => '-',
                'no_hp'        => null,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]));
        }

        $ippnuBase = [
            'kategori'           => 'IPPNU',
            'tingkatan'          => 'Cabang',
            'nama_tingkatan'     => 'PC IPPNU',
            'is_active'          => 1,
            'organisasi_id'      => null,
            'surat_keputusan_id' => 1,
            'created_at'         => $now,
            'updated_at'         => $now,
        ];

        $newPengurus = [
            // 2 Waket tambahan
            ['id' => 'pgr051', 'kader_id' => 'kdr201', 'jabatan' => 'Wakil Ketua',      'parent_id' => 'pgr039', 'departemen_id' => 'dep011', 'urutan_tampil' => 5],
            ['id' => 'pgr052', 'kader_id' => 'kdr202', 'jabatan' => 'Wakil Ketua',      'parent_id' => 'pgr039', 'departemen_id' => 'dep024', 'urutan_tampil' => 6],
            // 3 Wasek tambahan
            ['id' => 'pgr053', 'kader_id' => 'kdr203', 'jabatan' => 'Wakil Sekretaris', 'parent_id' => 'pgr044', 'departemen_id' => 'dep010', 'urutan_tampil' => 10],
            ['id' => 'pgr054', 'kader_id' => 'kdr204', 'jabatan' => 'Wakil Sekretaris', 'parent_id' => 'pgr044', 'departemen_id' => 'dep011', 'urutan_tampil' => 11],
            ['id' => 'pgr055', 'kader_id' => 'kdr205', 'jabatan' => 'Wakil Sekretaris', 'parent_id' => 'pgr044', 'departemen_id' => 'dep024', 'urutan_tampil' => 12],
            // 4 Wabend tambahan
            ['id' => 'pgr056', 'kader_id' => 'kdr206', 'jabatan' => 'Wakil Bendahara',  'parent_id' => 'pgr048', 'departemen_id' => 'dep012', 'urutan_tampil' => 13],
            ['id' => 'pgr057', 'kader_id' => 'kdr207', 'jabatan' => 'Wakil Bendahara',  'parent_id' => 'pgr048', 'departemen_id' => 'dep010', 'urutan_tampil' => 14],
            ['id' => 'pgr058', 'kader_id' => 'kdr208', 'jabatan' => 'Wakil Bendahara',  'parent_id' => 'pgr048', 'departemen_id' => 'dep011', 'urutan_tampil' => 15],
            ['id' => 'pgr059', 'kader_id' => 'kdr209', 'jabatan' => 'Wakil Bendahara',  'parent_id' => 'pgr048', 'departemen_id' => 'dep024', 'urutan_tampil' => 16],
            // 6 Koordinator (parent = respective Waket)
            ['id' => 'pgr060', 'kader_id' => 'kdr210', 'jabatan' => 'Koordinator', 'parent_id' => 'pgr040', 'departemen_id' => 'dep007', 'urutan_tampil' => 40],
            ['id' => 'pgr061', 'kader_id' => 'kdr211', 'jabatan' => 'Koordinator', 'parent_id' => 'pgr041', 'departemen_id' => 'dep008', 'urutan_tampil' => 41],
            ['id' => 'pgr062', 'kader_id' => 'kdr212', 'jabatan' => 'Koordinator', 'parent_id' => 'pgr042', 'departemen_id' => 'dep012', 'urutan_tampil' => 42],
            ['id' => 'pgr063', 'kader_id' => 'kdr213', 'jabatan' => 'Koordinator', 'parent_id' => 'pgr043', 'departemen_id' => 'dep010', 'urutan_tampil' => 43],
            ['id' => 'pgr064', 'kader_id' => 'kdr214', 'jabatan' => 'Koordinator', 'parent_id' => 'pgr051', 'departemen_id' => 'dep011', 'urutan_tampil' => 44],
            ['id' => 'pgr065', 'kader_id' => 'kdr215', 'jabatan' => 'Koordinator', 'parent_id' => 'pgr052', 'departemen_id' => 'dep024', 'urutan_tampil' => 45],
            // 6 Anggota dept (parent = respective Koordinator)
            ['id' => 'pgr066', 'kader_id' => 'kdr216', 'jabatan' => 'Anggota', 'parent_id' => 'pgr060', 'departemen_id' => 'dep007', 'urutan_tampil' => 60],
            ['id' => 'pgr067', 'kader_id' => 'kdr217', 'jabatan' => 'Anggota', 'parent_id' => 'pgr061', 'departemen_id' => 'dep008', 'urutan_tampil' => 61],
            ['id' => 'pgr068', 'kader_id' => 'kdr218', 'jabatan' => 'Anggota', 'parent_id' => 'pgr062', 'departemen_id' => 'dep012', 'urutan_tampil' => 62],
            ['id' => 'pgr069', 'kader_id' => 'kdr219', 'jabatan' => 'Anggota', 'parent_id' => 'pgr063', 'departemen_id' => 'dep010', 'urutan_tampil' => 63],
            ['id' => 'pgr070', 'kader_id' => 'kdr220', 'jabatan' => 'Anggota', 'parent_id' => 'pgr064', 'departemen_id' => 'dep011', 'urutan_tampil' => 64],
            ['id' => 'pgr071', 'kader_id' => 'kdr221', 'jabatan' => 'Anggota', 'parent_id' => 'pgr065', 'departemen_id' => 'dep024', 'urutan_tampil' => 65],
            // 4 Lembaga heads (parent = Ketua)
            ['id' => 'pgr072', 'kader_id' => 'kdr222', 'jabatan' => 'Direktur',   'parent_id' => 'pgr039', 'departemen_id' => 'dep020', 'urutan_tampil' => 50],
            ['id' => 'pgr073', 'kader_id' => 'kdr223', 'jabatan' => 'Direktur',   'parent_id' => 'pgr039', 'departemen_id' => 'dep021', 'urutan_tampil' => 51],
            ['id' => 'pgr074', 'kader_id' => 'kdr224', 'jabatan' => 'Direktur',   'parent_id' => 'pgr039', 'departemen_id' => 'dep023', 'urutan_tampil' => 52],
            ['id' => 'pgr075', 'kader_id' => 'kdr225', 'jabatan' => 'Direktur',   'parent_id' => 'pgr039', 'departemen_id' => 'dep022', 'urutan_tampil' => 53],
            // 4 Anggota lembaga (parent = respective head)
            ['id' => 'pgr076', 'kader_id' => 'kdr226', 'jabatan' => 'Anggota', 'parent_id' => 'pgr072', 'departemen_id' => 'dep020', 'urutan_tampil' => 70],
            ['id' => 'pgr077', 'kader_id' => 'kdr227', 'jabatan' => 'Anggota', 'parent_id' => 'pgr073', 'departemen_id' => 'dep021', 'urutan_tampil' => 71],
            ['id' => 'pgr078', 'kader_id' => 'kdr228', 'jabatan' => 'Anggota', 'parent_id' => 'pgr074', 'departemen_id' => 'dep023', 'urutan_tampil' => 72],
            ['id' => 'pgr079', 'kader_id' => 'kdr229', 'jabatan' => 'Anggota', 'parent_id' => 'pgr075', 'departemen_id' => 'dep022', 'urutan_tampil' => 73],
        ];

        foreach ($newPengurus as $p) {
            DB::table('pengurus')->insert(array_merge($p, $ippnuBase));
        }

        // Fix IPPNU urutan_tampil for existing entries
        $ippnuUrutan = [
            'pgr039' => 1,  // Ketua
            'pgr044' => 2,  // Sekretaris
            'pgr048' => 3,  // Bendahara
            'pgr040' => 4,  // Waket Organisasi
            'pgr041' => 4,  // Waket Kaderisasi
            'pgr042' => 4,  // Waket Jarkom
            'pgr043' => 4,  // Waket Dakwah
            'pgr045' => 7,  // Wasek Organisasi
            'pgr046' => 8,  // Wasek Kaderisasi
            'pgr047' => 9,  // Wasek Jarkom
            'pgr049' => 13, // Wabend Organisasi
            'pgr050' => 14, // Wabend Kaderisasi
        ];

        foreach ($ippnuUrutan as $id => $urutan) {
            DB::table('pengurus')->where('id', $id)->update(['urutan_tampil' => $urutan]);
        }

        // ============================================================
        // PART C: Fix IPNU urutan_tampil
        // ============================================================

        $ipnuUrutan = [
            'pgr012' => 1,  // Ketua
            'pgr013' => 2,  // Sekretaris
            'pgr014' => 3,  // Bendahara
            // Wakil Ketua (per dept)
            'pgr004' => 10, // Waket Organisasi
            'pgr008' => 11, // Waket Kaderisasi
            'pgr017' => 12, // Waket DJSP
            'pgr022' => 13, // Waket Dakwah
            'pgr027' => 14, // Waket Desbor
            // Wakil Sekretaris
            'pgr006' => 20, // Wasek Organisasi
            'pgr010' => 21, // Wasek Kaderisasi
            'pgr019' => 22, // Wasek DJSP
            'pgr024' => 23, // Wasek Dakwah
            'pgr029' => 24, // Wasek Desbor
            // Wakil Bendahara
            'pgr007' => 30, // Wabend Organisasi
            'pgr011' => 31, // Wabend Kaderisasi
            'pgr020' => 32, // Wabend DJSP
            'pgr025' => 33, // Wabend Dakwah
            'pgr030' => 34, // Wabend Desbor
            // Koordinator
            'pgr005' => 40, // Koord Organisasi
            'pgr009' => 41, // Koord Kaderisasi
            'pgr018' => 42, // Koord DJSP
            'pgr023' => 43, // Koord Dakwah
            'pgr028' => 44, // Koord Desbor
            // Lembaga heads
            'pgr032' => 50, // Komandan CBP
            'pgr034' => 51, // Direktur PERS
            'pgr036' => 52, // Direktur LAN
            // Anggota dept
            'pgr038' => 60, // Anggota Organisasi
            'pgr016' => 61, // Anggota Kaderisasi
            'pgr021' => 62, // Anggota DJSP
            'pgr026' => 63, // Anggota Dakwah
            'pgr031' => 64, // Anggota Desbor
            // Anggota lembaga
            'pgr033' => 70, // Anggota CBP
            'pgr035' => 71, // Anggota PERS
            'pgr037' => 72, // Anggota LAN
        ];

        foreach ($ipnuUrutan as $id => $urutan) {
            DB::table('pengurus')->where('id', $id)->update(['urutan_tampil' => $urutan]);
        }
    }
}
