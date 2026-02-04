<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\User;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have a user and category
        $user = User::first() ?? User::factory()->create();
        $kategori = KategoriBerita::firstOrCreate(
            ['nama' => 'Kegiatan'],
            ['slug' => 'kegiatan']
        );

        $titles = [
            'Pelatihan Jurnalistik Pelajar NU: Mengasah Nalar Kritis di Era Digital',
            'IPNU IPPNU Tanggap Bencana: Salurkan Bantuan untuk Korban Banjir',
            'Gebyar Sholawat & Pengajian Akbar Maulid Nabi Muhammad SAW',
            'Turnamen Futsal Santri Cup: Menjunjung Sportivitas Santri',
            'Beasiswa Pendidikan Kader Berprestasi Tahun 2024'
        ];

        foreach ($titles as $index => $title) {
            Berita::create([
                'kategori_berita_id' => $kategori->id,
                'user_id' => $user->id,
                'judul' => $title,
                'slug' => Str::slug($title),
                'thumbnail' => null, // Or use a placeholder if you have one seeded, but null is fine for now
                'konten' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'status' => 'Published',
                'tgl_publish' => now()->subDays($index * 2), // Spread out dates
                'views' => rand(50, 500),
            ]);
        }
    }
}
