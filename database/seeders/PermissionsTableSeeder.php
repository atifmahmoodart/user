<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'Root Node', 'guard_name' => 'web'],
            ['name' => 'Add Node', 'guard_name' => 'web'],
            ['name' => 'Update Node', 'guard_name' => 'web'],
            ['name' => 'Delete Node', 'guard_name' => 'web'],
            ['name' => 'Assign Node', 'guard_name' => 'web'],
            ['name' => 'Unassign Node', 'guard_name' => 'web'],
            ['name' => 'Create Device', 'guard_name' => 'web'],
            ['name' => 'Update Device', 'guard_name' => 'web'],
            ['name' => 'Delete Device', 'guard_name' => 'web'],
            ['name' => 'Assign Device', 'guard_name' => 'web'],
            ['name' => 'Unassign Device', 'guard_name' => 'web']
        ];

        // Create the permissions
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}