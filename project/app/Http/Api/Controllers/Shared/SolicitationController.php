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
     *     operationId="List all solicitations",
     *     tags={"Solicitations"},
     *     summary="List all solicitations",
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

    public function show(Solicitation $solicitation)
    {
        return ShowSolicitationResource::make($solicitation);
    }
}
