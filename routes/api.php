<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    Route::post('/assignRole', [UserController::class, 'assignRole'])->name('assignRole');
    Route::post('/unassignRole', [UserController::class, 'unassignRole'])->name('unassignRole');
});
Route::post('/signup', [UserController::class, 'signup'])->name('signup');
Route::post('/verifyOtp', [UserController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('/login', [UserController::class, 'login'])->name('login');