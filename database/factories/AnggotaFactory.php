<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnggotaFactory extends Factory
{
    protected $model = Anggota::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'anggota',
            ]),
            'nomor_anggota' => 'AGT-' . fake()->unique()->numerify('######'),
            'alamat' => fake()->address(),
            'no_telepon' => fake()->numerify('08##########'),
        ];
    }
}