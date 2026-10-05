<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'Token tidak ditemukan'
            ], 401);
        }

        try {

            $decoded = JWT::decode(
                $token,
                new Key(
                    config('jwt.secret'),
                    'HS256'
                )
            );

            $user = User::find(
                $decoded->sub
            );

            if (!$user) {
                return response()->json([
                    'message' => 'User tidak ditemukan'
                ], 401);
            }

            // Simpan user ke request
            $request->setUserResolver(
                function () use ($user) {
                    return $user;
                }
            );

        } catch (\Firebase\JWT\ExpiredException $e) {

            return response()->json([
                'message' => 'Token sudah kedaluwarsa'
            ], 401);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Token tidak valid',
                'error' => $e->getMessage(),
            ], 401);
        }

        return $next($request);
    }
}