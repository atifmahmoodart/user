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
            ['name' => 'Root Node'],
            ['name' => 'Add Node'],
            ['name' => 'Update Node'],
            ['name' => 'Delete Node'],
            ['name' => 'Assign Node'],
            ['name' => 'Unassign Node'],
            ['name' => 'Create Device'],
            ['name' => 'Update Device'],
            ['name' => 'Delete Device'],
            ['name' => 'Assign Device'],
            ['name' => 'Unassign Device'],
        ];

        // Create the permissions
        foreach ($permissions as $permissionData) {
            $permission = new Permission();
            $permission->name = $permissionData['name'];
            $permission->save();
        }
    }
}