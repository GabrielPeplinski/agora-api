<?php

namespace App\Http\Api\Controllers\Auth;

use Illuminate\Http\JsonResponse;

class LogoutController
{
    public function __invoke(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()
            ->json([
                'data' => [
                    'message' => 'User successfully logged out',
                    'name' => auth()->user()->name,
                    'status' => 200,
                ],
            ]);
    }
}
