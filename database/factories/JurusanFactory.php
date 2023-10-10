<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    public function definition(): array
    {
        $daftar_jurusan = ["Ilmu Komputer",
                          "Sistem Informasi",
                          "Teknik Informatika"];
        return [
            'nama' => $this->faker->unique()->randomElement($daftar_jurusan),
            'kepala_jurusan' => "Dr. ".$this->faker->firstName()." ".
                                $this->faker->lastName(),
            'daya_tampung'   => $this->faker->numberBetween(5,8)*10,
        ];
    }
}
