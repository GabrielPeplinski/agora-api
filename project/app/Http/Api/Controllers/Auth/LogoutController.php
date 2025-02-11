<?php

namespace App\Http\Api\Controllers\Auth;

use Illuminate\Http\JsonResponse;

class LogoutController
{
    /**
     * @OA\Delete(
     *     path="/api/auth/logout",
     *     operationId="Logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     description="Logout current user",
     *     security={{"sanctum":{}}},
     *
     *      @OA\Response(
     *          response=204,
     *          description="Successfully logged out user.",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Bad request")
     *          )
     *      ),
     *
     *      @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Failed to log out.")
     *         )
     *     ),
     * )
     */
    public function __invoke(): JsonResponse
    {
        $currentUser = auth()->user();

        if ($currentUser) {
            $currentUser->currentAccessToken()->delete();

            return response()->json([
                'message' => __('auth.logout_successfully'),
            ], 204);
        }

        return response()->json([
            'message' => __('auth.logout_failed'),
        ], 401);
    }
}
