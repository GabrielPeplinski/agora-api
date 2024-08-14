<?php

namespace App\Http\Api\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class UpdatePersonalDataController
{
    /**
     * @OA\Put(
     *     path="/api/auth/personal-data",
     *     operationId="UpdatePersonalData",
     *     tags={"Auth"},
     *     summary="Update Current User Data",
     *     description="Update the personal data of the current user, including the option to change the password.",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="New user name",
     *                 example="New User Name"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 description="A valid email address",
     *                 example="example@example.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="Current user account password",
     *                 example="12345"
     *             ),
     *             @OA\Property(
     *                 property="new_password",
     *                 type="string",
     *                 description="New password for the current account",
     *                 example="123456"
     *             ),
     *             @OA\Property(
     *                 property="new_password_confirmation",
     *                 type="string",
     *                 description="Confirmation of the new password",
     *                 example="123456"
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully updated current user personal data",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Suas informações pessoais foram atualizadas com sucesso"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Unauthorized"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Bad request"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(ref="#/components/schemas/UnprocessableEntityResponseExample")
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        $user = current_user();

        $data = $request->validate([
            'password' => ['required', 'string'],
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'new_password' => ['sometimes', 'string', 'min:5', 'confirmed'],
        ]);

        if (!Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => __('custom.invalid_current_user_password'),
            ]);
        }

        if (!empty($data['new_password'])) {
            $user->password = Hash::make($data['new_password']);
            Auth::logoutOtherDevices($data['new_password']);
        }

        unset($data['password']);
        unset($data['new_password']);
        $user->update($data);

        return response()->json([
            'message' => __('custom.personal_data_updated'),
        ]);
    }
}
