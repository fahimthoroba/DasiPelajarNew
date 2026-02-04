<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DepartemenUserSeeder extends Seeder
{
    public function run(): void
    {
        // Format: 'id' => 'depX' (must match DepartemenSeeder)
        $departments = [
            'dep1' => 'organisasi',
            'dep2' => 'kaderisasi',
            'dep3' => 'djsp',
            'dep4' => 'dakwah',
            'dep5' => 'budaya', // Seni Budaya
            'dep6' => 'pers', // Lembaga Pers
            'dep7' => 'cbp', // Lembaga CBP KPP
        ];

        foreach ($departments as $id => $slug) {
            User::updateOrCreate(
                ['email' => "{$slug}@dasipelajar.or.id"],
                [
                    'name' => "Departemen " . ucfirst($slug),
                    'password' => Hash::make('password'),
                    'role' => 'departemen',
                    'departemen_id' => $id,
                ]
            );
        }
    }
}
