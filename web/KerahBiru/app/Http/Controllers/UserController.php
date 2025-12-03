<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
        try {
            $userId = $request->query('user_id');
            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ditemukan',
                ], 404);
            }

            $user->save();

            $user->photo_url = $user->photo 
                ? asset('storage/' . $user->photo)
                : null;

            return response()->json([
                'success' => true,
                'message' => 'Profil Berhasil Diperbarui!',
                'user' => $user,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

public function updateProfile(Request $request)
{
    try {
        $userId = $request->get('user_id');
            $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('phone')) $user->phone = $request->phone;
        if ($request->has('address')) $user->address = $request->address;
        if ($request->has('latitude')) $user->latitude = $request->latitude;
        if ($request->has('longitude')) $user->longitude = $request->longitude;

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('users', 'public');
            $user->photo = $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil Berhasil Diperbarui!',
            'user' => $user,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
        ], 500);
    }
}

    public function updatePreferences(Request $request)
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

            if ($request->has('preferred_currency')) {
                $user->preferred_currency = $request->preferred_currency;
            }
            if ($request->has('preferred_timezone')) {
                $user->preferred_timezone = $request->preferred_timezone;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Preferensi diperbarui!',
                'user' => $user,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'current_password' => 'required',
                'new_password' => 'required|min:6',
            ]);

            $user = User::find($request->user_id);

            if ($user->password !== $request->current_password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kata sandi saat ini salah!',
                ], 401);
            }

            $user->password = $request->new_password;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Kata sandri berhasil diperbarui!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}