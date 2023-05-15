<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\APIRoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'jwt'], function () {
    Route::get('/getRoles', [APIRoleController::class, 'getRoles'])->name('getRoles');
    Route::post('/assignRole', [APIRoleController::class, 'assignRole'])->name('assignRole');
    Route::post('/unassignRole', [APIRoleController::class, 'unassignRole'])->name('unassignRole');
    Route::get('/getPermissions', [APIRoleController::class, 'getPermissions'])->name('getPermissions');
    Route::post('/createDevice', [APIRoleController::class, 'createDevice'])->name('createDevice');
});
Route::post('/signup', [UserController::class, 'signup'])->name('signup');
Route::post('/verifyOtp', [UserController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('/login', [UserController::class, 'login'])->name('login');