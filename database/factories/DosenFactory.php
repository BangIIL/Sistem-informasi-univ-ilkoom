<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class DosenFactory extends Factory
{
    public function definition(): array
    {
        $daftar_titel = ["M.Kom", "M.Sc", "M.T", "M.Si"];

        return [
            'nid'  => $this->faker->unique()->numerify('99######'),
            'nama' => $this->faker->firstName()." ".$this->faker->lastName()." ".
                      $this->faker->randomElement($daftar_titel),
            'jurusan_id' => $this->faker->numberBetween(1,
                      \App\Models\Jurusan::count()),
        ];
    }
}
