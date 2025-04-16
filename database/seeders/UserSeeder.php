<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'username' => 'admin123',
            'email' => 'adminn@gmail.com',
            'password' => bcrypt('admin')
        ]);
        User::create([
            'first_name' => 'Karn',
            'last_name' => 'Karn',
            'username' => 'karn123',
            'email' => 'karnn@gmail.com',
            'password' => bcrypt('karn')
        ]);
    }
}
