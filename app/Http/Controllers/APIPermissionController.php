<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIPermissionController extends Controller
{
    public function checkPermission(Request $request)
    {
        $user = $request->user();
        $permission = 'edit_post';
        if ($user->can($permission)) {
            return response()->json(['message' => 'Permission granted']);
        }
        return response()->json(['message' => 'Permission denied'], 403);
    }
}