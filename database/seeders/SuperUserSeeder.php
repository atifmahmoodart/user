<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTimestamp = Carbon::now();
        $superUser = User::create([
            'name' => 'Atif Mahmood',
            'email' => 'superuser@test.com',
            'password' => Hash::make('abc@123'),
            'otp' => rand(1000, 9999),
            'email_verified_at' => $currentTimestamp,
        ]);
        $roleId = Role::where('name', 'Super User')->pluck('id');
        DB::table('role_user')->insert([
            'user_id' => $superUser->id,
            'role_id' => $roleId[0],
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp,
        ]);
        $permissions = Permission::pluck('id')->all();
        foreach ($permissions as $permissionId) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permissionId,
                'role_id' => $roleId[0],
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp,
            ]);
            DB::table('user_permissions')->insert([
                'permission_id' => $permissionId,
                'user_id' => $superUser->id,
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp,
            ]);
        }
    }
}