<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Http\Controllers\APIPermissionController;
use Illuminate\Http\Request;
use App\Helpers;

class APIRoleController extends Controller
{
    public function getRoles(Request $request)
    {
        $role = 'Super User';
        $result = Helpers\hasRole($role);
        if ($result) {
            return app(UserController::class)->getRoles($request);
        }
        return response()->json(['message' => 'Role denied'], 403);
    }
    public function assignRole(Request $request)
    {
        $role = 'Super User';
        $result = Helpers\hasRole($role);
        if ($result) {
            return app(UserController::class)->assignRole($request);
        }
        return response()->json(['message' => 'Role denied'], 403);
    }
    public function unassignRole(Request $request)
    {
        $role = 'Super User';
        $result = Helpers\hasRole($role);
        if ($result) {
            return app(UserController::class)->unassignRole($request);
        }
        return response()->json(['message' => 'Role denied'], 403);
    }
    public function getPermissions(Request $request)
    {
        $role = 'Super User';
        $result = Helpers\hasRole($role);
        if ($result) {
            return app(UserController::class)->getPermissions($request);
        }
        return response()->json(['message' => 'Role denied'], 403);
    }
    public function createDevice(Request $request)
    {
        $role = 'Super User';
        $result = Helpers\hasRole($role);
        if ($result) {
            return app(APIPermissionController::class)->createDevice($request);
        }
        return response()->json(['message' => 'Role denied'], 403);
    }
}