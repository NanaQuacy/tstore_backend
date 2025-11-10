<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create owner role if it doesn't exist
        Role::firstOrCreate(
            ['name' => 'owner', 'guard_name' => 'web']
        );

        // You can add more roles here as needed
        // Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        // Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web']);
    }
}
