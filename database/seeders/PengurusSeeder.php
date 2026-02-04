<?php

namespace Database\Seeders;

use App\Models\Kader;
use App\Models\Pengurus;
use App\Models\SuratKeputusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate tables to avoid duplicates during dev
        Schema::disableForeignKeyConstraints();
        Pengurus::truncate();
        Kader::truncate();
        SuratKeputusan::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. SK Dummy
        $sk = SuratKeputusan::firstOrCreate(
            ['nomor_sk' => '001/PC/SK/XII/2025'],
            [
                'judul_sk' => 'SK Kepengurusan Masa Khidmat 2023-2025',
                'tgl_berlaku' => '2023-01-01',
                'tgl_selesai' => '2025-12-31',
            ]
        );

        $this->seedHierarchy('L', $sk->id, 0); // IPNU
        $this->seedHierarchy('P', $sk->id, 50); // IPPNU
    }

    private function seedHierarchy($gender, $skId, $baseIndex)
    {
        $orgName = $gender == 'L' ? 'PC IPNU Kediri' : 'PC IPPNU Kediri';

        // 1. Ketua
        $ketua = $this->createPengurus($gender, $skId, 'Ketua', $baseIndex + 1, 1, null);

        // 2. Sekretaris & Bendahara (under Ketua)
        $sekretaris = $this->createPengurus($gender, $skId, 'Sekretaris', $baseIndex + 2, 2, $ketua->id);
        $bendahara = $this->createPengurus($gender, $skId, 'Bendahara', $baseIndex + 3, 3, $ketua->id);

        // 3. Wakil Ketua 1 & 2 (under Ketua)
        $waket1 = $this->createPengurus($gender, $skId, 'Wakil Ketua I (Org)', $baseIndex + 4, 4, $ketua->id);
        $waket2 = $this->createPengurus($gender, $skId, 'Wakil Ketua II (Kader)', $baseIndex + 5, 5, $ketua->id);

        // 4. Wakil Sekretaris (under Sekretaris)
        $this->createPengurus($gender, $skId, 'Wakil Sekretaris I', $baseIndex + 6, 6, $sekretaris->id);
        $this->createPengurus($gender, $skId, 'Wakil Sekretaris II', $baseIndex + 7, 7, $sekretaris->id);

        // 5. Departemen/Lembaga (Under Wakil Ketua)
        // Dept Organisasi under Waket 1
        $koordOrg = $this->createPengurus($gender, $skId, 'Koordinator Dept. Organisasi', $baseIndex + 8, 8, $waket1->id);
        $this->createPengurus($gender, $skId, 'Anggota Dept. Organisasi', $baseIndex + 9, 9, $koordOrg->id);
        $this->createPengurus($gender, $skId, 'Anggota Dept. Organisasi', $baseIndex + 10, 10, $koordOrg->id);

        // Dept Kaderisasi under Waket 2
        $koordKader = $this->createPengurus($gender, $skId, 'Koordinator Dept. Kaderisasi', $baseIndex + 11, 11, $waket2->id);
        $this->createPengurus($gender, $skId, 'Anggota Dept. Kaderisasi', $baseIndex + 12, 12, $koordKader->id);
        $this->createPengurus($gender, $skId, 'Anggota Dept. Kaderisasi', $baseIndex + 13, 13, $koordKader->id);

        // Lembaga (Direct under Ketua for simplicity or create functional waka)
        $direkturLembaga = $this->createPengurus($gender, $skId, 'Direktur Lembaga Pers', $baseIndex + 14, 14, $ketua->id);
        $this->createPengurus($gender, $skId, 'Anggota Lembaga Pers', $baseIndex + 15, 15, $direkturLembaga->id);
    }

    private function createPengurus($gender, $skId, $jabatan, $index, $urutan, $parentId)
    {
        $kader = Kader::create([
            'nik' => '3506' . str_pad($index, 12, '0', STR_PAD_LEFT),
            'nama_lengkap' => ($gender == 'L' ? 'Rek. ' : 'Rekita. ') . fake('id_ID')->firstName . ' ' . fake('id_ID')->lastName,
            'jenis_kelamin' => $gender,
            'tempat_lahir' => 'Kediri',
            'tgl_lahir' => '2000-01-01',
            'desa' => 'Mojo',
            'kecamatan' => 'Mojo',
            'kabupaten' => 'Kediri',
            'no_hp' => '081234567' . str_pad($index, 3, '0', STR_PAD_LEFT),
            'quote' => fake('id_ID')->sentence(5),
            // Use UI Avatars based on gender
            'foto_path' => null,
        ]);

        return Pengurus::create([
            'kader_id' => $kader->id,
            'surat_keputusan_id' => $skId,
            'tingkatan' => 'Cabang',
            'nama_tingkatan' => 'PC IPNU IPPNU Kediri',
            'jabatan' => $jabatan,
            'urutan_tampil' => $urutan,
            'is_active' => true,
            'parent_id' => $parentId,
        ]);
    }
}
