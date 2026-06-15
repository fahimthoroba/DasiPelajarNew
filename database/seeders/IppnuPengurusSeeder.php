<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IppnuPengurusSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Tambah kader perempuan untuk pengurus IPPNU
        $kaders = [
            ['id' => 'kdr189', 'nama_lengkap' => 'Nur Azizah Fitriani',      'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => 'Perempuan yang kuat adalah perempuan yang terus belajar.'],
            ['id' => 'kdr190', 'nama_lengkap' => 'Siti Maimunah',             'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => 'Berdaya, berprestasi, berakhlak mulia.'],
            ['id' => 'kdr191', 'nama_lengkap' => 'Lailatul Qomariyah',        'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => ''],
            ['id' => 'kdr192', 'nama_lengkap' => 'Dewi Masithoh',             'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => 'Organisasi adalah sekolah kehidupan terbaik.'],
            ['id' => 'kdr193', 'nama_lengkap' => 'Rizky Amalia Putri',        'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => ''],
            ['id' => 'kdr194', 'nama_lengkap' => 'Faridatul Ulfah',           'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => 'Lillah, ikhlas berjuang untuk sesama.'],
            ['id' => 'kdr195', 'nama_lengkap' => 'Nila Rohmatus Sholihah',   'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => ''],
            ['id' => 'kdr196', 'nama_lengkap' => 'Ainun Jariyah',             'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => 'Maju bersama, tumbuh bersama.'],
            ['id' => 'kdr197', 'nama_lengkap' => 'Khoirunnisa Rahmawati',    'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => ''],
            ['id' => 'kdr198', 'nama_lengkap' => 'Umi Hanik',                 'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => 'Pelajar putri NU: cerdas, tangguh, berakhlak.'],
            ['id' => 'kdr199', 'nama_lengkap' => 'Zulaikha Nurfadhilah',     'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => ''],
            ['id' => 'kdr200', 'nama_lengkap' => 'Maulida Hasanah',           'jenis_kelamin' => 'P', 'kabupaten' => 'Kediri', 'quote' => 'Ilmu dan amal, dua sayap untuk terbang.'],
        ];

        foreach ($kaders as $kader) {
            \Illuminate\Support\Facades\DB::table('kaders')->insert(array_merge($kader, [
                'nik'           => null,
                'foto_path'     => null,
                'tempat_lahir'  => 'Kediri',
                'tgl_lahir'     => null,
                'alamat_jalan'  => null,
                'dusun'         => null,
                'desa'          => '-',
                'kecamatan'     => '-',
                'no_hp'         => null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]));
        }

        // Tambah pengurus IPPNU (BPH Harian + Waka)
        $pengurus = [
            ['id' => 'pgr039', 'kader_id' => 'kdr189', 'jabatan' => 'Ketua',           'urutan_tampil' => 1],
            ['id' => 'pgr040', 'kader_id' => 'kdr190', 'jabatan' => 'Wakil Ketua',     'urutan_tampil' => 2],
            ['id' => 'pgr041', 'kader_id' => 'kdr191', 'jabatan' => 'Wakil Ketua',     'urutan_tampil' => 3],
            ['id' => 'pgr042', 'kader_id' => 'kdr192', 'jabatan' => 'Wakil Ketua',     'urutan_tampil' => 4],
            ['id' => 'pgr043', 'kader_id' => 'kdr193', 'jabatan' => 'Wakil Ketua',     'urutan_tampil' => 5],
            ['id' => 'pgr044', 'kader_id' => 'kdr194', 'jabatan' => 'Sekretaris',      'urutan_tampil' => 6],
            ['id' => 'pgr045', 'kader_id' => 'kdr195', 'jabatan' => 'Wakil Sekretaris','urutan_tampil' => 7],
            ['id' => 'pgr046', 'kader_id' => 'kdr196', 'jabatan' => 'Wakil Sekretaris','urutan_tampil' => 8],
            ['id' => 'pgr047', 'kader_id' => 'kdr197', 'jabatan' => 'Wakil Sekretaris','urutan_tampil' => 9],
            ['id' => 'pgr048', 'kader_id' => 'kdr198', 'jabatan' => 'Bendahara',       'urutan_tampil' => 10],
            ['id' => 'pgr049', 'kader_id' => 'kdr199', 'jabatan' => 'Wakil Bendahara', 'urutan_tampil' => 11],
            ['id' => 'pgr050', 'kader_id' => 'kdr200', 'jabatan' => 'Wakil Bendahara', 'urutan_tampil' => 12],
        ];

        foreach ($pengurus as $p) {
            \Illuminate\Support\Facades\DB::table('pengurus')->insert(array_merge($p, [
                'kategori'           => 'IPPNU',
                'tingkatan'          => 'Cabang',
                'nama_tingkatan'     => 'PC IPPNU',
                'is_active'          => 1,
                'organisasi_id'      => null,
                'parent_id'          => null,
                'departemen_id'      => null,
                'surat_keputusan_id' => 1,
                'created_at'         => $now,
                'updated_at'         => $now,
            ]));
        }
    }
}
