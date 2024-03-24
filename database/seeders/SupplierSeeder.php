<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
       Supplier::insert([
            [
                'name' => 'Apple'
            ],
            [
                'name' => 'HyperX'
            ],
            [
                'name' => 'Google'
            ],
            [
                'name' => 'Acer'
            ],
            [
                'name' => 'Intel'
            ],
            [
                'name' => 'AMD'
            ],
            [
                'name' => 'Lenovo'
            ],
       ]);
    }
}
