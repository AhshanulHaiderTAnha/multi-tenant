<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // public function run(): void
    // {
    //     User::factory()->admin()->create([
    //         'email' => 'admin@example.com',
    //         'password' => Hash::make('dev21@1234'),
    //     ]);
        
    // }
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'oadmin',
                'password' => Hash::make('dev21@1234'),
                'email_verified_at' => now(),
            ]
        );
    }
} 