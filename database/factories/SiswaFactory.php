<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition()
    {
        return [
            'kelas_id' => 1,
            'nama' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'alamat' => $this->faker->address(),
            'nama_wali' => $this->faker->name(),
            'telp_wali' => $this->faker->phoneNumber(),
            'pekerjaan_wali' => $this->faker->randomElement(['Wiraswasta', 'PNS', 'Karyawan Swasta']),
            'is_yatim' => $this->faker->boolean(20) // 20% chance true
        ];
    }
}
