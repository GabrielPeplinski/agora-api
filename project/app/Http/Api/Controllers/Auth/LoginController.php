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
            abort(401, 'Invalid credentials');
        }

        $token = auth()->user()->createToken('auth_token');

        return response()
            ->json([
                'data' => [
                    'message' => 'User successfully logged',
                    'token' => $token->plainTextToken,
                    'name' => auth()->user()->name,
                    'status' => 201,
                ],
            ]);
    }
}
