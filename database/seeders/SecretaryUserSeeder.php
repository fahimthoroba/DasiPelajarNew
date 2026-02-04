<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SecretaryUserSeeder extends Seeder
{
    public function run()
    {
        try {
            $user = User::firstOrCreate(
                ['email' => 'sekretaris@dasipelajar.or.id'],
                [
                    'name' => 'Admin Sekretaris',
                    'password' => Hash::make('password'),
                    'role' => 'sekretaris'
                ]
            );

            // Force update to ensure role and password are correct if user existed
            $user->role = 'sekretaris';
            $user->password = Hash::make('password');
            $user->save();

            $this->command->info('User sekretaris@dasipelajar.or.id created successfully.');
        } catch (\Exception $e) {
            $this->command->error('Error creating secretary user: ' . $e->getMessage());
        }
    }
}
