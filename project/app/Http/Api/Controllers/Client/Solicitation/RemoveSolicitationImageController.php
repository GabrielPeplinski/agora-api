<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\RemoveSolicitationImagesAction;
use App\Domains\Solicitation\Dtos\RemoveSolicitationImageData;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Request\Client\Solicitation\RemoveSolicitationImageRequest;
use App\Http\Shared\Controllers\Controller;

class RemoveSolicitationImageController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/client/my-solicitations/{mySolicitationId}/remove-images",
     *     operationId="Remove images from a Solicitation",
     *     tags={"My Solicitations"},
     *     summary="Remove images from a Solicitation",
     *     description="Remove images from a Solicitation, using an array of the images links",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="mySolicitationId",
     *         in="path",
     *         description="The id of the solicitation",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         description="Array of image full URLs to remove from the solicitation",
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *             required={"imageUrls"},
     *
     *             @OA\Property(
     *                 property="imageUrls",
     *                 type="array",
     *                 example=
     *
     *                 @OA\Items(type="string", format="url")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully removed images from a solicitation",
     *     ),
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
     *     )
     * )
     */
    public function __invoke(RemoveSolicitationImageRequest $request, Solicitation $mySolicitation)
    {
        $this->authorize('addImages', $mySolicitation);

        $data = RemoveSolicitationImageData::validateAndCreate($request->validated());

        app(RemoveSolicitationImagesAction::class)
            ->execute($mySolicitation, $data);
    }
}
