<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            ['nama' => 'Mie Goreng', 'harga' => 12000, 'stok' => 30, 'satuan' => 'pcs'],
            ['nama' => 'Es Teh', 'harga' => 5000, 'stok' => 50, 'satuan' => 'gelas'],
            ['nama' => 'Rokok', 'harga' => 25000, 'stok' => 40, 'satuan' => 'bungkus'],
        ]);
    }
}
