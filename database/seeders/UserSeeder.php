<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Departemen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin
        User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@dasi.org',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Department Users (karena mereka login via akun khusus, bukan personal)
        $depts = Departemen::all();
        foreach ($depts as $dept) {
            // Generate email slug from nama_departemen (e.g., kaderisasi@dasi.org)
            $slug = \Illuminate\Support\Str::slug($dept->nama_departemen);

            User::create([
                'name' => 'Admin ' . $dept->nama_departemen,
                'email' => $slug . '@dasi.org',
                'password' => Hash::make('password'),
                'role' => 'departemen',
                'departemen_id' => $dept->id,
            ]);
        }
    }
}
