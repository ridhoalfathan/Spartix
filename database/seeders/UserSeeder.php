<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Owner
        User::updateOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'name' => 'Pemilik Toko',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'email_verified_at' => now(),
            ]
        );
    }
}
