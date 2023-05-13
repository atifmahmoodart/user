<?php

namespace App\Helpers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


if (!function_exists('hasRole')) {
    function hasRole($role)
    {
        $user = Auth::user();
        $roleId = Role::where('name', $role)->pluck('id');
        $results = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.role_id', $roleId)
            ->where('role_user.user_id', $user->id)
            ->get();
        if (!$results->isEmpty()) {
            return true;
        }
        return false;
    }
}
if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        $user = Auth::user();
        $permissionId = Permission::where('name', $permission)->pluck('id');
        $results = DB::table('users')
            ->join('user_permissions', 'users.id', '=', 'user_permissions.user_id')
            ->where('user_permissions.pemission_id', $permissionId)
            ->where('user_permissions.user_id', $user->id)
            ->get();
        if (!$results->isEmpty()) {
            return true;
        }
        return false;
    }
}