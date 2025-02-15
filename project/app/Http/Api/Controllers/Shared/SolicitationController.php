<?php

namespace App\Http\Api\Controllers\Shared;

use App\Domains\Shared\Filters\Solicitation300MetersRadiusFilter;
use App\Domains\Solicitation\Filters\SolicitationStatusFilter;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Resources\Shared\Solicitation\ShowSolicitationResource;
use App\Http\Api\Resources\Shared\Solicitation\SolicitationResource;
use App\Support\PaginationBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class SolicitationController
{
    /**
     * @OA\Get(
     *     path="/api/solicitations",
     *     operationId="List all solicitations",
     *     tags={"Solicitations"},
     *     summary="Show all solicitations data",
     *     description="Get a paginated list with all solicitations",
     *
     *     @OA\Parameter(
     *         name="filter[status]",
     *         in="query",
     *         description="Filter by status",
     *         required=false,
     *
     *         @OA\Schema(
     *             type="string",
     *             enum={"open", "in_progress", "resolved"},
     *             example="open"
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *          name="filter[current_location]",
     *          in="query",
     *          description="User current location to filter solicitations within 300 meters radius",
     *          required=false,
     *
     *          @OA\Schema(
     *              type="string",
     *              example="-23.5505199,-46.6333094"
     *          )
     *      ),
     *
     *     @OA\Parameter(
     *         name="filter[solicitation_category_id]",
     *         in="query",
     *         description="Filter by the solicitation category ID",
     *         required=false,
     *
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
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
            ->allowedFilters([
                AllowedFilter::exact('solicitation_category_id'),
                AllowedFilter::custom('status', new SolicitationStatusFilter),
                AllowedFilter::custom('current_location', new Solicitation300MetersRadiusFilter),
            ])
            ->defaultSort('-created_at')
            ->resource(SolicitationResource::class);
    }

    /**
     * @OA\Get(
     *     path="/api/solicitations/{solicitationId}",
     *     operationId="Show the data of any solicitation",
     *     tags={"Solicitations"},
     *     summary="Show the data of any solicitation",
     *     description="Show the data of a solicitation",
     *
     *     @OA\Parameter(
     *       name="solicitationId",
     *       in="path",
     *       description="The id of one solicitation",
     *       required=true,
     *
     *       @OA\Schema(type="integer")
     *    ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully return a solicitation data",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ShowSolicitationResponse")
     *     ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *
     *          @OA\JsonContent(
     *
     *           @OA\Property(property="message", type="string", example="Bad request")
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
     *         response=404,
     *         description="Solicitation not found"
     *     )
     * )
     */
    public function show(Solicitation $solicitation)
    {
        $solicitation->loadMissing([
            'media',
            'category',
        ]);

        return ShowSolicitationResource::make($solicitation);
    }
}
