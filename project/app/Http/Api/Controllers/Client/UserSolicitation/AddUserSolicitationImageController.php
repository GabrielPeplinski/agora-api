<?php

namespace App\Http\Api\Controllers\Client\UserSolicitation;

use App\Domains\Solicitation\Actions\UserSolicitation\AddUserSolicitationImageAction;
use App\Domains\Solicitation\Exceptions\CannotAddUserSolicitationImageException;
use App\Domains\Solicitation\Models\UserSolicitation;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AddUserSolicitationImageController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/client/my-user-solicitations/{myUserSolicitationId}/add-image",
     *     operationId="Add a Image to an User Solicitation",
     *     tags={"My User Solicitations"},
     *     summary="Add a Image to an User Solicitation",
     *     description="Add a Image to an User Solicitation. Used for adding an image to a solicitation after updating its status",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="myUserSolicitationId",
     *         in="path",
     *         description="The id of the user solicitation",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         description="Image to add to the user solicitation",
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="application/octet-stream",
     *
     *             @OA\Schema(type="string", format="binary")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully added an image to an user solicitation",
     *     ),
     *
     *     @OA\Response(
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
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ForbiddenResponseExample")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Solicitation not found",
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *
     *         @OA\JsonContent(ref="#/components/schemas/UnprocessableEntityResponseExample")
     *     )
     * )
     */
    public function __invoke(Request $request, UserSolicitation $myUserSolicitation)
    {
        try {
            $mySolicitation = $myUserSolicitation->solicitation;

            $this->authorize('updateStatus', $mySolicitation);

            $uuid = Str::uuid();
            $fileContent = $request->getContent();
            $tempFilePath = sys_get_temp_dir() . "/solicitation-$mySolicitation->id-$uuid";

            file_put_contents($tempFilePath, $fileContent);

            $file = new File($tempFilePath);

            app(AddUserSolicitationImageAction::class)
                ->execute($myUserSolicitation, $file);

            unlink($tempFilePath);
        } catch (CannotAddUserSolicitationImageException $exception) {
            throw ValidationException::withMessages([
                $exception->getMessage(),
            ]);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => $exception->getMessage(),
                ], 500);
        }
    }
}
