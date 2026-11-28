<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pm@batabutu.test'],
            [
                'name' => 'Admin PM',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'pustakawan',
            ]
        );

        User::updateOrCreate(
            ['email' => 'anggota@batabutu.test'],
            [
                'name' => 'Anggota Uji',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'anggota',
            ]
        );
    }
}