<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\Resources\MeResource;
use App\Http\Shared\Controllers\Controller;

class MeController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/auth/me",
     *     operationId="Me",
     *     tags={"Auth"},
     *     summary="Current user data",
     *     description="Current user data",
     *     security={{"sanctum":{}}},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Current user data successfully retrieved",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="name", type="string", example="Current User"),
     *              @OA\Property(property="email", type="string", example="test@gmail.com"),
     *              @OA\Property(property="created_at", type="string", example="2024-02-13 22:13:55.000"),
     *              @OA\Property(property="updated_at", type="string", example="2024-02-13 22:13:55.000")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     * )
     */
    public function __invoke()
    {
        $user = current_user();

        return MeResource::make($user);
    }
}
