<?php

namespace Database\Seeders;

use App\Models\Kader;
use Illuminate\Database\Seeder;

class KaderDummySeeder extends Seeder
{
    public function run()
    {
        // Add 10 dummy kaders using the Factory
        Kader::factory()->count(10)->create();
    }
}
