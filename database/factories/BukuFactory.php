<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Penulis;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    protected $model = Buku::class;

    public function definition(): array
    {
        return [
            'penulis_id' => Penulis::factory(),
            'judul' => fake()->sentence(3),
            'isbn' => fake()->unique()->numerify('978##########'),
            'tahun_terbit' => fake()->numberBetween(2000, 2026),
            'stok' => fake()->numberBetween(1, 50),
            'deskripsi' => fake()->paragraph(),
            'cover_path' => null,
            'ebook_path' => null,
        ];
    }
}