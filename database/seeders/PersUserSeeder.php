<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PersUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'pers@dasipelajar.or.id'],
            [
                'name' => 'Admin Pers',
                'password' => Hash::make('password'),
                'role' => 'pers'
            ]
        );

        // Force update password to be sure
        $user->password = Hash::make('password');
        $user->save();

        $this->command->info('User pers@dasipelajar.or.id created/updated with password: password');
    }
}
