<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KasirSeeder::class, // panggil seeder kasir kamu di sini
            // tambahkan seeder lain nanti kalau ada
        ]);
    }
}
