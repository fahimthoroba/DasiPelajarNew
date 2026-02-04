<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaturanWeb;

class PengaturanWebSeeder extends Seeder
{
    public function run(): void
    {
        PengaturanWeb::firstOrCreate([
            'id' => 1
        ], [
            'nama_website' => 'DASI Pelajar',
            'deskripsi_singkat' => 'Database & Administrasi Sistem Informasi Pelajar',
            'logo_path' => null,
            'email' => 'info@dasipelajar.or.id', // Corrected from email_organisasi
            'no_wa' => '081234567890', // Corrected from no_telp
            'facebook' => 'https://facebook.com',
            'instagram' => 'https://instagram.com',
            'tiktok' => null,
            'youtube' => null,
            'alamat' => 'Jl. Kramat Raya No. 164, Jakarta Pusat',
            // maps_embed removed (not in schema)
            // hero_title removed (not in schema)
            'header_news_title' => 'Warta Pelajar', // Corrected from news_header_title
            'header_news_desc' => 'Informasi Terkini Seputar Kegiatan Pelajar NU', // Corrected from news_header_desc
        ]);
    }
}
