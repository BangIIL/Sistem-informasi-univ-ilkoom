<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaMatakuliahFactory extends Factory
{
    public function definition(): array
    {
        $mahasiswa_id = $this->faker->numberBetween(1,
                        \App\Models\Mahasiswa::count());

        $jurusan_mahasiswa_id = \App\Models\Mahasiswa::find($mahasiswa_id)
                                ->jurusan_id;

        $array_matakuliah = \App\Models\Matakuliah::where('jurusan_id',
                            $jurusan_mahasiswa_id)->get('id');

        return [
            'mahasiswa_id' => $mahasiswa_id,
            'matakuliah_id' => $this->faker->randomElement($array_matakuliah),
        ];
    }
}
