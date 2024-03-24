<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'code' => '00012332',
                'title' => 'HyperX Mousepad',
                'price' => 15.86,
            ],
            [
                'code' => '878990213',
                'title' => 'Macbook Air',
                'price' => 1233.96,
            ],
            [
                'code' => '2231',
                'title' => 'Earphone KZ EDX Pro',
                'price' => 5.20,
            ],
            [
                'code' => '2311321',
                'title' => 'Airpods 2',
                'price' => 55.99,
            ],
        ]);
    }
}
