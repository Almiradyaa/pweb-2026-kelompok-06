<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    public function definition(): array
    {
        // Menentukan tanggal peminjaman secara acak
        $tanggalPinjam = now()->subDays(
            fake()->numberBetween(1, 5)
        );

        return [
            'anggota_id' => Anggota::factory(),
            'buku_id' => Buku::factory(),

            // Tanggal buku mulai dipinjam
            'tanggal_pinjam' => $tanggalPinjam->toDateString(),

            // Batas peminjaman adalah 5 hari setelah tanggal pinjam
            'tanggal_kembali_rencana' => $tanggalPinjam
                ->copy()
                ->addDays(5)
                ->toDateString(),

            // Belum ada pengembalian aktual
            'tanggal_dikembalikan' => null,

            // Status awal peminjaman
            'status' => 'dipinjam',

            // Catatan bersifat opsional
            'catatan' => fake()->optional()->sentence(),
        ];
    }
}