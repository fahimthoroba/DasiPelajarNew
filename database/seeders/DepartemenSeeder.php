<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        $depts = [
            // Departemen
            'Organisasi',
            'Kaderisasi',
            'DJSP',
            'Dakwah',
            'Desbor', // Dekora Seni Budaya & Olahraga?
            'Jarkom', // IPPNU Only

            // Lembaga IPNU
            'CBP',
            'LPP',
            'LAN',
            'LEKAS',
            'LKPT',
            'BSCC',
            'BSRC',

            // Lembaga IPPNU
            'KPP',
            'LKP',
            'LKDC',
            'LEK',
        ];

        foreach ($depts as $d) {
            // Check existence to avoid dupes if re-running without fresh
            if (!Departemen::where('nama_departemen', $d)->exists()) {
                Departemen::create([
                    'nama_departemen' => $d
                ]);
            }
        }
    }
}
