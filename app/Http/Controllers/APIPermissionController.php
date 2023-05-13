<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Helpers;

class APIPermissionController extends Controller
{
    public function createDevice($request)
    {
        $permission = 'Create Device';
        $result = Helpers\hasPermission($permission);
        if ($result) {
            return app(UserController::class)->createDevice($request);
        }
        return response()->json(['message' => 'Permission denied'], 403);
    }
}