<?php

namespace App\Http\Api\Auth;

use App\Domains\Account\Models\User;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request, User $user): JsonResponse
    {
        $userData = $request->validate([
            'email' => 'required|string',
            'name' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        $userData['password'] = bcrypt($userData['password']);

        if (! $user = $user->create($userData)) {
            abort(500, 'Error to create a new user');
        }

        return response()
            ->json([
                'data' => [
                    'message' => 'User successfully registered',
                    'name' => $user->name,
                    'status' => 201,
                ],
            ]);
    }
}
