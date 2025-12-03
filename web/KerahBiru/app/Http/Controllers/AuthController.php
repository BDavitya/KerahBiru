<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->is_verified = false; // Belum verified
            $user->save();

            // Generate token untuk session
            $token = 'dummy_token_' . $user->id;

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Lakukan verifikasi keamanan.',
                'user' => $user,
                'token' => $token,
                'needs_shake_verification' => true,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Method baru untuk verifikasi shake
    public function verifyShake(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            // Set user sebagai verified
            $user->is_verified = true;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil!',
                'user' => $user,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak ditemukan.',
                ], 404);
            }

            if ($user->password !== $request->password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah.',
                ], 401);
            }

            if (!$user->is_verified) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun belum diverifikasi.',
                    'needs_shake_verification' => true,
                    'user' => $user,
                    'token' => 'dummy_token_' . $user->id,
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'user' => $user,
                'token' => 'dummy_token_' . $user->id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil!',
        ]);
    }

    public function completeProfile(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|string',
                'address' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $token = $request->header('Authorization');
            $userId = null;

            if ($token) {
                $userId = str_replace(['Bearer ', 'dummy_token_'], '', $token);
            }

            $user = $userId ? User::find($userId) : User::latest()->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil dilengkapi!',
                'user' => $user,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }
}