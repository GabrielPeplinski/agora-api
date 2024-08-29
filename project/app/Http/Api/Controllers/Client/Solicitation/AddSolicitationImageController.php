<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Strategies\SolicitationImage\AddSolicitationImageStrategy;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddSolicitationImageController extends Controller
{
    /**
     * @OA\Post (
     *     path="/api/client/my-solicitations/{mySolicitationId}/add-image",
     *     operationId="Add a Image to a Solicitation",
     *     tags={"Solicitations"},
     *     summary="Add a Image to a Solicitation",
     *     description="Add a image as a temporary path to a solicitation",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *          name="mySolicitationId",
     *          in="path",
     *          description="The id of the solicitation",
     *          required=true,
     *
     *          @OA\Schema (type="integer")
     *       ),
     *
     *     @OA\RequestBody(
     *          description="Image to add to the solicitation",
     *          required=true,
     *
     *          @OA\MediaType(
     *              mediaType="application/octet-stream",
     *
     *              @OA\Schema(type="string", format="binary")
     *          )
     *      ),
     *
     *      @OA\Response(
     *           response=200,
     *           description="Successfully added an image to a solicitation",
     *       ),
     *      @OA\Response(
     *           response=400,
     *           description="Bad request",
     *
     *           @OA\JsonContent(
     *
     *               @OA\Property(property="message", type="string", example="Bad request")
     *           )
     *       ),
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
     *     @OA\Response(
     *        response=403,
     *         description="Forbidden",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ForbiddenResponseExample")
     *     )
     * )
     */
    public function __invoke(Request $request, Solicitation $mySolicitation)
    {
        $this->authorize('addImages', $mySolicitation);

        $uuid = Str::uuid();
        $fileContent = $request->getContent();
        $tempFilePath = sys_get_temp_dir()."/solicitation-$mySolicitation->id-$uuid";

        file_put_contents($tempFilePath, $fileContent);

        $file = new File($tempFilePath);

        app(AddSolicitationImageStrategy::class)
            ->execute($mySolicitation, $file, true);

        unlink($tempFilePath);
    }
}
