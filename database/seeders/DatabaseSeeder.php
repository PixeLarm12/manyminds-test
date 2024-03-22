<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Manyminds User',
            'email' => 'user.manyminds@gmail.com',
            'password' => bcrypt('123123'),
        ]);
    }
}
