<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp' => rand(1000, 9999)
        ]);

        // Send email OTP to user's email
        // You can use a package like Laravel Mail to send emails

        return response()->json(['success' => true, 'message' => 'OTP sent to your email']);
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

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid email address'], 422);
        }

        if ($user->otp === $request->otp) {
            $user->email_verified_at = now();
            $user->save();

            return response()->json(['success' => true, 'message' => 'OTP verified successfully']);
        }

        return response()->json(['error' => 'Invalid OTP'], 422);
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

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = JWTAuth::fromUser(Auth::user());

            return response()->json(['success' => true, 'token' => $token]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
