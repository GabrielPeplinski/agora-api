<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string',
        ]);

        if (! auth()->attempt($credentials)) {
            abort(401, 'Credenciais inválidas');
        }

        $token = auth()->user()->createToken('auth_token');

        return response()
            ->json([
                'message' => 'User successfully logged',
                'tokenType' => 'Bearer',
                'token' => $token->plainTextToken,
            ], 201);
    }
}
