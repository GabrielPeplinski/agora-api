<?php

namespace App\Http\Api\Controllers\Auth;

use App\Domains\Account\Models\User;
use App\Domains\Shared\Enums\RolesEnum;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     operationId="Regiter",
     *     tags={"Auth"},
     *     summary="Register User",
     *     description="Register a new user",
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
     *              @OA\Property(
     *                  type="string",
     *                  default="123456",
     *                  description="New user password",
     *                  property="password"
     *              ),
     *              @OA\Property(
     *                   type="string",
     *                   default="123456",
     *                   description="New user password confirmation",
     *                   property="password_confirmation"
     *               )
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Successfully registered user",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Usuário criado com sucesso."),
     *              @OA\Property(property="name", type="string", example="New User")
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

        //        $user->assignRole(RolesEnum::CLIENT);

        return response()
            ->json([
                'message' => 'Usuário criado com sucesso.',
                'name' => $user->name,
            ], 201);
    }
}
