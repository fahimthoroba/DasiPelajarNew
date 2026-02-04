<?php

namespace Database\Seeders;

use App\Models\Kader;
use App\Models\Pengurus;
use App\Models\SuratKeputusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StrukturDummySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Clear existing data to fix "unnecessary cards" issue
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Pengurus::truncate();
        Kader::truncate();
        SuratKeputusan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Dummy SK
        $sk = SuratKeputusan::create([
            'nomor_sk' => '001/PC/A/XII/7354/X/2024',
            'judul_sk' => 'Pengesahan PC IPNU Kediri 2024-2026',
            'tgl_berlaku' => now(),
            'tgl_selesai' => now()->addYears(2),
            'file_sk_path' => null,
        ]);

        // Create IPNU structure (L) and IPPNU (P)?? User view handles both tabs.
        // The user didn't specify, but the diagram implies one structure.
        // I will create for IPNU (L).

        $this->createStructure($faker, 'L', $sk->id);
        $this->createStructure($faker, 'P', $sk->id);
    }

    private function createStructure($faker, $gender, $skId)
    {
        $tingkatan = 'Cabang';
        $namaTingkatan = 'PC ' . ($gender == 'L' ? 'IPNU' : 'IPPNU') . ' Kediri';

        // 1. Ketua
        $ketuaKader = Kader::create([
            'nama_lengkap' => $faker->name($gender == 'L' ? 'male' : 'female'),
            'nik' => $faker->nik,
            'jenis_kelamin' => $gender,
            'tempat_lahir' => $faker->city,
            'tgl_lahir' => $faker->date,
            'alamat_jalan' => $faker->address,
            'dusun' => $faker->streetName,
            'desa' => $faker->city, // Faker doesn't have specific desa, use city/street
            'kecamatan' => $faker->city,
            'kabupaten' => 'Kediri',
            'no_hp' => $faker->phoneNumber,
        ]);

        $ketua = Pengurus::create([
            'kader_id' => $ketuaKader->id,
            'parent_id' => null,
            'surat_keputusan_id' => $skId,
            'tingkatan' => $tingkatan,
            'nama_tingkatan' => $namaTingkatan,
            'jabatan' => 'Ketua',
            'urutan_tampil' => 1,
            'is_active' => true,
        ]);

        // 2. Sekretaris & 4 Wakil
        $this->createNode($faker, $gender, $ketua->id, $skId, 'Sekretaris', 2);
        for ($i = 1; $i <= 4; $i++) {
            $this->createNode($faker, $gender, $ketua->id, $skId, 'Wakil Sekretaris ' . $i, 3); // Child of Ketua for Flat Logic
        }

        // 3. Bendahara & 4 Wakil
        $this->createNode($faker, $gender, $ketua->id, $skId, 'Bendahara', 4);
        for ($i = 1; $i <= 4; $i++) {
            $this->createNode($faker, $gender, $ketua->id, $skId, 'Wakil Bendahara ' . $i, 5);
        }

        // 4. 4 Wakil Ketua (Departemen)
        for ($i = 1; $i <= 4; $i++) {
            $waka = $this->createNode($faker, $gender, $ketua->id, $skId, 'Wakil Ketua ' . $i, 6 + $i);

            // 1 Koordinator
            $coord = $this->createNode($faker, $gender, $waka->id, $skId, 'Koordinator Departemen ' . $i, 1);

            // 3 Anggota under Koordinator
            for ($j = 1; $j <= 3; $j++) {
                $this->createNode($faker, $gender, $coord->id, $skId, 'Anggota', $j);
            }
        }

        // 5. 4 Lembaga
        $lembagaNames = ['CBP', 'Pers', 'Ekonomi', 'Dakwah'];
        // For IPPNU maybe KPP?
        if ($gender == 'P')
            $lembagaNames = ['KPP', 'Jurnalistik', 'Kewirausahaan', 'Konseling'];

        foreach ($lembagaNames as $idx => $lName) {
            // Lembaga Direktur is child of Ketua (Level 4)
            $direktur = $this->createNode($faker, $gender, $ketua->id, $skId, 'Direktur ' . $lName, 20 + $idx);

            // 3 Anggota
            for ($j = 1; $j <= 3; $j++) {
                $this->createNode($faker, $gender, $direktur->id, $skId, 'Anggota', $j);
            }
        }
    }

    private function createNode($faker, $gender, $parentId, $skId, $jabatan, $urutan)
    {
        $kader = Kader::create([
            'nama_lengkap' => $faker->name($gender == 'L' ? 'male' : 'female'),
            'nik' => $faker->nik(),
            'jenis_kelamin' => $gender,
            'tempat_lahir' => $faker->city,
            'tgl_lahir' => $faker->date,
            'alamat_jalan' => $faker->address,
            'dusun' => $faker->streetName,
            'desa' => $faker->city,
            'kecamatan' => $faker->city,
            'kabupaten' => 'Kediri',
            'no_hp' => $faker->phoneNumber,
        ]);

        return Pengurus::create([
            'kader_id' => $kader->id,
            'parent_id' => $parentId,
            'surat_keputusan_id' => $skId,
            'tingkatan' => 'Cabang',
            'nama_tingkatan' => 'PC Test',
            'jabatan' => $jabatan,
            'urutan_tampil' => $urutan,
            'is_active' => true,
        ]);
    }
}
