<?php

namespace Database\Factories;

use App\Models\Tabungan;
use Illuminate\Database\Eloquent\Factories\Factory;

class TabunganFactory extends Factory
{
    protected $model = Tabungan::class;

    public function definition()
    {
        $jumlah = $this->faker->numberBetween(5000, 50000);
        
        return [
            'siswa_id' => 1,
            'tipe' => $this->faker->randomElement(['in', 'out']),
            'jumlah' => $jumlah,
            'saldo' => $jumlah, // Will be recalculated in tests
            'keperluan' => $this->faker->optional()->sentence(5)
        ];
    }
}
