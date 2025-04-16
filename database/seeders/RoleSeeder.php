<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole=Role::Create([
            'name' => 'admin'
        ]);
        $userRole=Role::Create([
            'name' => 'user'
        ]);
        $get_admin = User::where('email', 'karnn@gmail.com')->first();
        $get_admin->roles()->attach($adminRole);
        $get_user= User::where('email', 'nishan@gmail.com')->first();
        $get_user->roles()->attach($userRole);
    }
}
