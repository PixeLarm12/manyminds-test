<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Manyminds User',
            'email' => 'manyminds@support.com',
            'password' => bcrypt('123123'),
        ]);
    }
}
