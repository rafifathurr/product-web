<?php

namespace Database\Seeders;

use App\Models\product\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Eau De Parfum Baccarat',
            'price' => 150000,
        ]);

        Product::create([
            'name' => 'Eau De Parfum Sauvage',
            'price' => 150000,
        ]);
    }
}
