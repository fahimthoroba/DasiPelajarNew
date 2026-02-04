<?php

namespace Database\Factories;

use App\Models\Kader;
use Illuminate\Database\Eloquent\Factories\Factory;

class KaderFactory extends Factory
{
    protected $model = Kader::class;

    public function definition()
    {
        $gender = $this->faker->randomElement(['L', 'P']);
        return [
            'nik' => $this->faker->numerify('################'),
            'nama_lengkap' => $this->faker->name($gender == 'L' ? 'male' : 'female'),
            'foto_path' => null, // Or generic avatar logic if needed
            'tempat_lahir' => $this->faker->city,
            'tgl_lahir' => $this->faker->date,
            'jenis_kelamin' => $gender,
            'alamat_jalan' => $this->faker->streetAddress,
            'dusun' => $this->faker->streetName,
            'desa' => $this->faker->city,
            'kecamatan' => $this->faker->city,
            'kabupaten' => 'Kediri',
            'no_hp' => $this->faker->phoneNumber,
            'quote' => $this->faker->sentence,
        ];
    }
}
