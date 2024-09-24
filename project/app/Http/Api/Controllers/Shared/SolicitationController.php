<?php

namespace App\Http\Api\Controllers\Shared;

use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Resources\Shared\Solicitation\ShowSolicitationResource;
use App\Http\Api\Resources\Shared\Solicitation\SolicitationResource;
use App\Support\PaginationBuilder;

class SolicitationController
{
    /**
     * @OA\Get(
     *     path="/api/solicitations",
     *     operationId="List all solicitations",
     *     tags={"Solicitations"},
     *     summary="Show a solicitation data",
     *     description="Get a paginated list with all solicitations",
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully liked or unliked a solicitation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/SolicitationPaginatedResponse")
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
     *         response=400,
     *         description="Bad request",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Bad request")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return PaginationBuilder::for(Solicitation::class)
            ->with([
                'media',
            ])
            ->allowedSorts(['created_at', 'updated_at'])
            ->defaultSort('-created_at')
            ->resource(SolicitationResource::class);
    }

    /**
     * @OA\Get(
     *     path="/api/solicitations/{solicitationId}",
     *     operationId="Show a Solicitation Data for Unauthenticated Users",
     *     tags={"Solicitations"},
     *     summary="Show the data of a solicitation",
     *     description="Show the data of a solicitation",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully liked or unliked a solicitation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ShowSolicitationResponse")
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
     *         response=404,
     *         description="Solicitation not found"
     *     )
     * )
     */
    public function show(Solicitation $solicitation)
    {
        return ShowSolicitationResource::make($solicitation);
    }
}
