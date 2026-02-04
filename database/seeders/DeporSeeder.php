<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeporSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'Depor@dasi.org'],
            [
                'name' => 'Dep. Organisasi',
                'password' => \Illuminate\Support\Facades\Hash::make('deporpelopor'),
                'role' => 'dep_organisasi',
                'departemen_id' => 'DEP-ORG',
            ]
        );
    }
}
