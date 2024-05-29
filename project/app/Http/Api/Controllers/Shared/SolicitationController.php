<?php

namespace App\Http\Api\Controllers\Shared;

use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Resources\Client\Solicitation\SolicitationResource;
use App\Http\Api\Resources\Shared\Solicitation\ShowSolicitationResource;
use App\Support\PaginationBuilder;

class SolicitationController
{
    /**
     * @OA\Get  (
     *     path="/api/solicitations",
     *     operationId="Show a solicitation data",
     *     tags={"Solicitations"},
     *     summary="Show a solicitation data",
     *     description="Get a paginated list with all solicitations",
     *
     *      @OA\Response(
     *           response=200,
     *           description="Successfully liked or unliked a solicitation",
     *
     *           @OA\JsonContent(ref="#/components/schemas/SolicitationPaginatedResponse")
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
    public function index()
    {
        return PaginationBuilder::for(Solicitation::class)
            ->with([
                'images',
                'coverImage',
            ])
            ->resource(SolicitationResource::class);
    }

    /**
     * @OA\Get  (
     *     path="/api/solicitations/{solicitationId}",
     *     operationId="Show a Solicitation Data for Unauthenticated Users",
     *     tags={"Solicitations"},
     *     summary="Show the data of a solicitation",
     *     description="Show the data of a solicitation",
     *
     *      @OA\Response(
     *           response=200,
     *           description="Successfully liked or unliked a solicitation",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ShowSolicitationResponse")
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
    public function show(Solicitation $solicitation)
    {
        return ShowSolicitationResource::make($solicitation);
    }
}
