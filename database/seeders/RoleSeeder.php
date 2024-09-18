<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the roles with their name, role, and status
        $roles = [
            ['name' => 'Super Admin', 'role' => 'super-admin', 'status' => 1],
            ['name' => 'Admin', 'role' => 'admin', 'status' => 1],
            ['name' => 'Vendor', 'role' => 'vendor', 'status' => 1],
            ['name' => 'User', 'role' => 'user', 'status' => 1],
        ];

        // Insert roles into the roles table
        DB::table('roles')->insert($roles);
    }
}
