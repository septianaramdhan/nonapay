<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    \App\Models\Kasir::create([
        'nama_kasir' => 'Noneng',
        'username' => 'noneng',
        'password' => bcrypt('12345'),
    ]);
}

}
