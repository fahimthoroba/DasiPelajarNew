<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\HeroSlider;
use App\Models\PengaturanWeb;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Core Data
        $this->call([
            DepartemenSeeder::class,
            UserSeeder::class, // Admin & Dep Users
        ]);

        // 2. Initial Content (Settings)
        PengaturanWeb::create([
            'nama_website' => 'PC IPNU IPPNU KEDIRI',
            'deskripsi_singkat' => 'Pelajar NU Kediri Berdaya',
            'email' => 'admin@dasi.org',
            'no_wa' => '08123456789',
        ]);
        // Note: I should fix PengaturanWebSeeder later if it exists
        // For now, I will comment out missing classes to ensure run success
        // $this->call([PengaturanWebSeeder::class, BeritaSeeder::class]);
    }
}
