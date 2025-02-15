<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Exceptions\CannotDeleteSolicitationException;
use App\Domains\Solicitation\Exceptions\CannotUpdateSolicitationException;
use App\Domains\Solicitation\Filters\SolicitationStatusFilter;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Strategies\Solicitation\CreateSolicitationStrategy;
use App\Domains\Solicitation\Strategies\Solicitation\DeleteSolicitationStrategy;
use App\Domains\Solicitation\Strategies\Solicitation\UpdateSolicitationStrategy;
use App\Http\Api\Request\Client\Solicitation\SolicitationRequest;
use App\Http\Api\Resources\Shared\Solicitation\ShowSolicitationResource;
use App\Http\Api\Resources\Shared\Solicitation\SolicitationResource;
use App\Http\Shared\Controllers\Controller;
use App\Support\PaginationBuilder;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;

class MySolicitationsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/client/my-solicitations",
     *     operationId="List all my solicitations",
     *     tags={"My Solicitations"},
     *     summary="List all my solicitations",
     *     description="Get a paginated list with all current user solicitations",
     *     security={{"sanctum":{}}},
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
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ForbiddenResponseExample")
     *     )
     * )
     */
    public function index()
    {
        $this->authorize('view', Solicitation::class);

        $mySolicitations = app(Solicitation::class)
            ->whereHas('userSolicitations', function ($query) {
                $query->where('user_id', current_user()->id)
                    ->where('action_description', SolicitationActionDescriptionEnum::CREATED);
            });

        return PaginationBuilder::for($mySolicitations)
            ->allowedFilters([
                AllowedFilter::custom('status', new SolicitationStatusFilter),
            ])
            ->allowedSorts(['created_at', 'updated_at'])
            ->defaultSort('-created_at')
            ->resource(SolicitationResource::class);
    }

    private function show(Solicitation $solicitation): ShowSolicitationResource
    {
        $solicitation->loadMissing([
            'media',
            'category',
        ]);

        return ShowSolicitationResource::make($solicitation);
    }

    /**
     * @OA\Post(
     *     path="/api/client/my-solicitations",
     *     operationId="Create Solicitation",
     *     tags={"My Solicitations"},
     *     summary="Create a solicitation",
     *     description="Create a solicitation using the current user",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *
     *        @OA\JsonContent(ref="#/components/schemas/SolicitationPayload")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Successfully registered user address",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ShowSolicitationResponse")
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
     *         response=422,
     *         description="Unprocessable Entity",
     *
     *         @OA\JsonContent(ref="#/components/schemas/UnprocessableEntityResponseExample")
     *     )
     * )
     */
    public function store(SolicitationRequest $request)
    {
        $this->authorize('create', Solicitation::class);

        $data = SolicitationData::validateAndCreate([
            ...$request->validated(),
            'currentStatus' => SolicitationStatusEnum::OPEN,
            'userSolicitationData' => [
                'status' => SolicitationStatusEnum::OPEN,
                'userId' => current_user()->id,
                'actionDescription' => SolicitationActionDescriptionEnum::CREATED,
            ],
        ]);

        $solicitation = app(CreateSolicitationStrategy::class)
            ->execute($data);

        return $this->show($solicitation);
    }

    /**
     * @OA\Put(
     *     path="/api/client/my-solicitations/{mySolicitationId}",
     *     operationId="Update Solicitation",
     *     tags={"My Solicitations"},
     *     summary="Update a solicitation",
     *     description="Update a solicitation that belongs to the current user",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="mySolicitationId",
     *         in="path",
     *         description="The id of the solicitation to update",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *
     *         @OA\JsonContent(ref="#/components/schemas/SolicitationPayload")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Successfully registered user address",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ShowSolicitationResponse")
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
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *
     *         @OA\JsonContent(ref="#/components/schemas/UnprocessableEntityResponseExample")
     *     )
     * )
     */
    public function update(SolicitationRequest $request, Solicitation $mySolicitation)
    {
        $this->authorize('update', $mySolicitation);

        try {
            $data = SolicitationData::validateAndCreate([
                ...$request->validated(),
                'userSolicitationData' => [
                    'status' => $mySolicitation->current_status,
                    'likesAmount' => $mySolicitation->likes_amount,
                    'solicitationId' => $mySolicitation->id,
                    'userId' => current_user()->id,
                    'actionDescription' => SolicitationActionDescriptionEnum::UPDATED,
                ],
            ]);

            $mySolicitation = app(UpdateSolicitationStrategy::class)
                ->execute($data, $mySolicitation);

            return $this->show($mySolicitation);
        } catch (CannotUpdateSolicitationException $exception) {
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

    /**
     * @OA\Delete(
     *     path="/api/client/my-solicitations/{mySolicitationId}",
     *     operationId="Delete Solicitation",
     *     tags={"My Solicitations"},
     *     summary="Delete a solicitation",
     *     description="Delete a solicitation that belongs to the current user",
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
     *     @OA\Response(
     *         response=204,
     *         description="Successfully deleted a solicitation",
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
     *         description="Not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *
     *         @OA\JsonContent(ref="#/components/schemas/UnprocessableEntityResponseExample")
     *     )
     * )
     */
    public function destroy(Solicitation $mySolicitation)
    {
        $this->authorize('delete', $mySolicitation);

        try {
            app(DeleteSolicitationStrategy::class)
                ->execute($mySolicitation);

            return response()->noContent();
        } catch (CannotDeleteSolicitationException $exception) {
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
