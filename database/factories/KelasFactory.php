<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition()
    {
        return [
            'periode_id' => 1, // Default periode
            'nama' => $this->faker->randomElement(['TK A', 'TK B', 'Playgroup'])
        ];
    }
}
