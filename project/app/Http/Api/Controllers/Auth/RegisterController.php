<?php

namespace App\Http\Api\Controllers\Auth;

use App\Domains\Account\Models\User;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        $userData = $request->validate([
            'email' => 'required|string',
            'name' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        $userData['password'] = Hash::make($userData['password']);

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
