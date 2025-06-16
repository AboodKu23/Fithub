<?php

namespace App\Services\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedService
{
    public function login(array $credentials): JsonResponse
    {
        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password'
            ]);
        }
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        return response()->json(compact('token', 'user'));
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        if (!$user)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }
        $user->tokens()->delete();
        return response()->json(compact('user'));
    }
}
