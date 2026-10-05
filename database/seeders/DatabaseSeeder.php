<?php

namespace Database\Seeders;

// use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ini adalah tempat untuk menjalankan semua seeder 
        // yang telah dibuat
        $this->call([
            UserSeeder::class,
            KaryawanSeeder::class,
            KriteriaSeeder::class,
            PenilaianSeeder::class,
            DetailPenilaianSeeder::class,
        ]);
    }
}
