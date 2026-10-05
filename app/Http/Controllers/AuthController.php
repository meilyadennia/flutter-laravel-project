<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // 2. Cari user berdasarkan email
        $user = User::where(
            'email',
            $validated['email']
        )->first();

        // 3. Jika user tidak ditemukan
        if (!$user) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        // 4. Verifikasi password hash
        if (!Hash::check(
            $validated['password'],
            $user->password
        )) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        // 5. Waktu token dibuat
        $issuedAt = time();

        // 6. Waktu token kedaluwarsa
        $expiredAt =
            $issuedAt + config('jwt.ttl');

        // 7. Payload JWT
        $payload = [
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'iat' => $issuedAt,
            'exp' => $expiredAt,
        ];

        // 8. Generate JWT
        $token = JWT::encode(
            $payload,
            config('jwt.secret'),
            'HS256'
        );

        // 9. Response login
        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ], 200);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'message' => 'Data profile berhasil diambil',
            'user' => $request->user(),
        ]);
    }
}