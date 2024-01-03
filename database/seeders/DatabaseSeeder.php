<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Material;
use App\Models\Workorder;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         Workorder::factory(5)->create();
         Material::create([
            'nama' => "Network Combat",
            'harga' => 150000
         ]);

         Material::create([
            'nama' => "Kabel Fiber",
            'harga' => 250000
         ]);

         Material::create([
            'nama' => "RJ45",
            'harga' => 25000
         ]);

         Material::create([
            'nama' => "Modem",
            'harga' => 100000
         ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Riyadh',
            'email' => 'riyadh@gmail.com',
        ]);
        // Workorder::create([
        //     'nomor_tiket' => 'TCKT-12345',
        //     'tipe_segmen' => 'Seeder',
        //     'lokasi_gangguan_masal' => 'Alamat Gangguan',
        //     'deskripsi_gangguan' => 'Deskripsi Gangguan',
        //     'instruksi_pekerjaan' => 'Instruksi Pekerjaan',
        //     'status' => 'Menunggu',
        // ]);
    }
}
