<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KasirSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kasirs')->updateOrInsert(
            ['username' => 'noneng'], // cek berdasarkan username
            [
                'nama_kasir' => 'Noneng',
                'password' => Hash::make('12345'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}