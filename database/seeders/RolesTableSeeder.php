<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Super User'],
            ['name' => 'Product Manager'],
            ['name' => 'Master User'],
            ['name' => 'User'],
        ];
        foreach ($roles as $roleData) {
            $role = new Role();
            $role->name = $roleData['name'];
            $role->save();
        }
    }
}