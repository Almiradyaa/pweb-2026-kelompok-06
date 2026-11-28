<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Penulis;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat atau memperbarui akun admin
        User::updateOrCreate(
            [
                'email' => env('ADMIN_EMAIL'),
            ],
            [
                'name' => 'Admin Perpustakaan',
                'password' => env('ADMIN_PASSWORD'),
                'role' => 'pustakawan',
            ]
        );

        // 2. Membuat 5 data penulis
        $penulis = Penulis::factory(5)->create();

        // 3. Membuat 20 data buku dengan penulis secara acak
        $buku = Buku::factory(20)->create([
            'penulis_id' => fn () => $penulis->random()->id,
        ]);

        // 4. Membuat 10 data anggota beserta akun pengguna
        $anggota = Anggota::factory(10)->create();

        // 5. Membuat 15 data peminjaman
        Peminjaman::factory(15)
            ->state(fn () => [
                'anggota_id' => $anggota->random()->id,
                'buku_id' => $buku->random()->id,
            ])
            ->create();
    }
}