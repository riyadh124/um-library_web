<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workorder>
 */
class WorkorderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_tiket' => 'TCKT-' . uniqid(),
            'tipe_segmen' => ['Distribusi', 'Seeder'][random_int(0, 1)],
            'lokasi_gangguan_masal' => $this->faker->address(),
            'deskripsi_gangguan' => $this->faker->sentence(mt_rand(5,10)),
            'instruksi_pekerjaan' =>  $this->faker->sentence(mt_rand(5,20)),
            'status' => 'Waiting',
            // 'foto_sebelum_pekerjaan' => json_encode(['image1.jpg', 'image2.jpg']),
            // 'list_material' => json_encode([
            //     ['nama' => 'material 1', 'harga' => 50000, 'total' => 5],
            //     ['nama' => 'material 2', 'harga' => 150000, 'total' => 3],
            // ]),'foto_setelah_pekerjaan' => json_encode(['image3.jpg', 'image4.jpg']),
            // 'foto_sebelum_pekerjaan' => json_encode(['image1.jpg', 'image2.jpg']),
            // 'list_material' => json_encode(['material1', 'material2']),
            // 'foto_setelah_pekerjaan' => json_encode(['image3.jpg', 'image4.jpg']),
        ];
    }
}
