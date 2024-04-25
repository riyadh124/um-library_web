<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrow;
use App\Models\Material;
use App\Models\Workorder;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

      Book::factory()->create([
         'kode_buku' => 'AbCDe',
         'judul_buku' => 'Buku 1',
         'pengarang' => 'Avatar Roku',
         'penerbit' => 'PT. Nickelodeon',
         'cover' => 'STL099670.jpeg',
         'tahun_terbit' => '2019',
         'status' => 'Tersedia',
     ]);

     Book::factory()->create([
      'kode_buku' => 'XyZEg',
      'judul_buku' => 'Buku 2',
      'pengarang' => 'Spongebob Squarepants : The Beningging',
      'penerbit' => 'PT. Nickelodeon',
      'cover' => '91jCK6VRgJL._SL1500_.jpg',
      'tahun_terbit' => '2001',
      'status' => 'Dipinjam',
  ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Riyadh Asjad Mulyadi',
            'email' => 'riyadh@gmail.com',
        ]);

        User::factory()->create([
         'name' => 'Admin',
         'email' => 'admin@gmail.com',
         'role' => 'Admin',
        ]);

        Borrow::create([
            'user_id' => 1,
            'book_id' => 1,
            'borrowed_at' => Carbon::now()->subDays(10), // Contoh tanggal pinjam 10 hari yang lalu
            'returned_at' => Carbon::now()->subDays(5),  // Contoh tanggal pengembalian 5 hari yang lalu
            'overdue_fine' => 0, // Biaya keterlambatan
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
