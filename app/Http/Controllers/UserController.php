<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
        DB::beginTransaction();
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'otp' => rand(1000, 9999)
            ]);
            $otp = $user->otp;
            Mail::to($user->email)->send(new OtpMail($otp));
            DB::commit();
            return response()->json(['success' => true, 'message' => 'OTP sent to your email']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while signing up'], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            DB::beginTransaction();
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['error' => 'Invalid email address'], 422);
            }
            if ($user->otp === $request->otp) {
                $user->email_verified_at = now();
                $user->save();
                DB::commit();
                return response()->json(['success' => true, 'message' => 'OTP verified successfully']);
            }
            return response()->json(['error' => 'Invalid OTP'], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while verifying OTP'], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            DB::beginTransaction();
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $token = JWTAuth::fromUser(Auth::user());
                DB::commit();
                return response()->json(['success' => true, 'token' => $token]);
            }
            DB::rollBack();
            return response()->json(['error' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred during login'], 500);
        }
    }
    public function assignRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'role_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            DB::beginTransaction();
            if($request->role_id){
                return response()->json(['error' => 'The role is not allowed to assign any user'], 403);
            }
            $check = DB::table('role_user')->where('user_id', $request->user_id)->where('role_id', $request->role_id)->get();
            if(!$check->isEmpty()){
                return response()->json(['error' => 'The role is already assigned to this user'], 403);
            }
            $user = User::where('id', $request->user_id)->first();
            $role = Role::where('id', $request->role_id)->first();
            $user->roles()->attach($role);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Role assign successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred during assign role'], 500);
        }
    }

    public function unassignRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'role_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            DB::beginTransaction();
            if($request->role_id){
                return response()->json(['error' => 'The role is not allowed to unassign'], 403);
            }
            $check = DB::table('role_user')->where('user_id', $request->user_id)->where('role_id', $request->role_id)->get();
            if($check->isEmpty()){
                return response()->json(['error' => 'The role is not assigned to this user'], 403);
            }
            $user = User::where('id', $request->user_id)->first();
            $role = Role::where('id', $request->role_id)->first();
            $user->roles()->detach($role);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Role detach successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred during assign role'], 500);
        }
    }
}