<?php

namespace App\Http\Api\Controllers\Auth;

use Illuminate\Http\JsonResponse;

class LogoutController
{
    public function __invoke(): JsonResponse
    {
        $currentUser = auth()->user();

        if ($currentUser) {
            $currentUser->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Usuário deslogado com sucesso.',
            ], 204);
        }

        return response()->json([
            'error' => 'Não foi possível realizar o logout.',
        ], 401);
    }
}
