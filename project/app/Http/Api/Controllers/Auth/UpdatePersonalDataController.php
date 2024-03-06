<?php

namespace App\Http\Api\Controllers\Auth;

class UpdatePersonalDataController
{
    /**
     * @OA\Put(
     *     path="/api/auth/personal-data",
     *     operationId="Personal Data",
     *     tags={"Auth"},
     *     summary="Update Current User",
     *     description="Update current user personal data",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                   type="string",
     *                   default="New User",
     *                   description="New user name",
     *                   property="name"
     *               ),
     *              @OA\Property(
     *                  type="string",
     *                  default="example@example.com",
     *                  description="A valid email address",
     *                  property="email"
     *              ),
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successfully updated current user personal data",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Suas informações foram atualizadas com sucesso"),
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
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Bad request")
     *          )
     *      ),
     * )
     */
    public function __invoke()
    {
        $user = current_user();

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        $user->update($data);

        return response()->json([
            'message' => 'Suas informações foram atualizadas com sucesso',
        ]);
    }
}
