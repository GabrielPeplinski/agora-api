<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Strategies\SolicitationImage\AddSolicitationImageStrategy;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddSolicitationImageController
{
    //    /**
    //     * @OA\Post (
    //     *     path="/api/client/solicitations/like",
    //     *     operationId="Like or Unlike a Solicitation",
    //     *     tags={"Solicitations"},
    //     *     summary="Like or unlike a solicitation",
    //     *     description="Like or unlike a solicitation by its id",
    //     *     security={{"sanctum":{}}},
    //     *
    //     *     @OA\RequestBody(
    //     *
    //     *          @OA\JsonContent(
    //     *              type="object",
    //     *
    //     *              @OA\Property(
    //     *                   type="integer",
    //     *                   default="1",
    //     *                   description="A solicitation ID",
    //     *                   property="solicitationId"
    //     *               ),
    //     *          ),
    //     *      ),
    //     *
    //     *      @OA\Response(
    //     *           response=200,
    //     *           description="Successfully liked or unliked a solicitation",
    //     *       ),
    //     *      @OA\Response(
    //     *          response=401,
    //     *          description="Unauthorized",
    //     *
    //     *          @OA\JsonContent(
    //     *
    //     *              @OA\Property(property="message", type="string", example="Unauthorized")
    //     *          )
    //     *      ),
    //     *
    //     *      @OA\Response(
    //     *          response=400,
    //     *          description="Bad request",
    //     *
    //     *          @OA\JsonContent(
    //     *
    //     *              @OA\Property(property="message", type="string", example="Bad request")
    //     *          )
    //     *      ),
    //     * )
    //     */
    public function __invoke(Request $request, Solicitation $mySolicitation)
    {
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
