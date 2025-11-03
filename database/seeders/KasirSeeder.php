<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KasirSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kasirs')->insert([
            'nama_kasir' => 'Kasir Utama',
            'username' => 'kasir',
            'password' => Hash::make('12345'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
