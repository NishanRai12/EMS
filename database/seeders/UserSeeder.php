<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $admin= User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'username' => 'admin123',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin')
        ]);
        $findAdminRole = Role::where('role_name', 'admin')->first();
        $admin->roles()->attach($findAdminRole->id);
        $user= User::create([
            'first_name' => 'User',
            'last_name' => 'User',
            'username' => 'User123',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user')
        ]);
        $getUserRole = Role::where('role_name', 'user')->first();
        $user->roles()->attach($getUserRole->id);
    }
}
