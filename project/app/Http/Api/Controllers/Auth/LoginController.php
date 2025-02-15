<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     operationId="Login",
     *     tags={"Auth"},
     *     summary="User Login",
     *     description="User Login",
     *
     *     @OA\RequestBody(
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  type="string",
     *                  default="example@example.com",
     *                  description="email",
     *                  property="email"
     *              ),
     *              @OA\Property(
     *                  type="string",
     *                  default="123456",
     *                  description="password",
     *                  property="password"
     *              )
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Login Successfully",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="tokenType", type="string", example="Bearer"),
     *              @OA\Property(property="message", type="string", example="User successfully logged in."),
     *              @OA\Property(property="token", type="string", example="1|Lkhuda45dajdanfi45")
     *          )
     *      ),
     *
     *      @OA\Response(
     *         response=400,
     *         description="Bad request",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Bad request")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Invalid login credentials")
     *         )
     *      ),
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string',
        ]);

        if (! auth()->attempt($credentials)) {
            return response()
                ->json([
                    'message' => __('auth.invalid_login_credentials'),
                ], 401);
        }

        $token = auth()->user()->createToken('auth_token');

        return response()
            ->json([
                'message' => __('auth.login_successful'),
                'tokenType' => 'Bearer',
                'token' => $token->plainTextToken,
            ], 201);
    }
}
