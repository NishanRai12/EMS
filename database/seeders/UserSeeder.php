<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'Nishan',
            'email' => 'nishan@gmail.com',
            'password' => Hash::make('nishan'),
            'role' => 'admin',
            'first_name' => 'Nishan',
            'last_name' => 'Rai',
        ]);
        User::create([
            'username' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'role' => 'user',
            'first_name' => 'Kalu',
            'last_name' => 'Rai',
        ]);
    }
}
