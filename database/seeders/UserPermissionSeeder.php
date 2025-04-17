<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();

        $adminPermissions = range(1, 95);

        foreach ($adminPermissions as $permissionId) {
            DB::table('permission_role')->updateOrInsert(
                ['role_id' => 2, 'permission_id' => $permissionId],
                ['created_at' => $timestamp, 'updated_at' => $timestamp]
            );
        }
    }
}
