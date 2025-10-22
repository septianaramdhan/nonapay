<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kasir;

class KasirSeeder extends Seeder
{
    public function run(): void
    {
        Kasir::create([
            'username' => 'kasir',
            'password' => Hash::make('12345'),
        ]);
    }
}
