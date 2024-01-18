<?php

namespace App\Http\Api\Controllers\Auth;

use App\Domains\Account\Models\User;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $userData = $request->validate([
            'email' => 'required|string',
            'name' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        $userData['password'] = Hash::make($userData['password']);

        if (! $user = User::create($userData)) {
            abort(500, 'Não foi possível cadastrar o usuário.');
        }

        return response()
            ->json([
                'message' => 'Usuário criado com sucesso.',
                'name' => $user->name,
            ], 201);
    }
}
