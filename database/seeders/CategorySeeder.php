<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('username', 'admin123')->firstorFail();
        Category::firstOrcreate([
            'name' => 'Health',
            'user_id'=> $user->id
        ]);
        Category::firstOrcreate([
            'name' => 'Food',
            'user_id'=> $user->id
        ]);
        Category::firstOrcreate([
            'name' => 'Groceries',
            'user_id'=> $user->id
        ]);
        Category::firstOrcreate([
            'name' => 'Entertainment',
            'user_id'=> $user->id
        ]);
    }
}
