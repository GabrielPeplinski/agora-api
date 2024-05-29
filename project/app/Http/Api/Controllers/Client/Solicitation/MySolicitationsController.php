<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Filters\SolicitationStatusFilter;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Strategies\CreateSolicitationStrategy;
use App\Domains\Solicitation\Strategies\DeleteSolicitationStrategy;
use App\Domains\Solicitation\Strategies\UpdateSolicitationStrategy;
use App\Http\Api\Request\Client\SolicitationRequest;
use App\Http\Api\Resources\Client\Solicitation\SolicitationResource;
use App\Support\PaginationBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class MySolicitationsController
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
     *          name="status",
     *          in="query",
     *          description="Filter by status",
     *          required=false,
     *
     *          @OA\Schema(
     *              type="string",
     *              enum={"open", "in_progress", "resolved"},
     *              example="open"
     *          )
     *      ),
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
        $mySolicitations = app(Solicitation::class)
            ->whereHas('userSolicitations', function ($query) {
                $query->where('user_id', current_user()->id)
                    ->where('action_description', SolicitationActionDescriptionEnum::CREATED);
            });

        return PaginationBuilder::for($mySolicitations)
            ->allowedFilters([
                AllowedFilter::custom('status', new SolicitationStatusFilter()),
            ])
            ->resource(SolicitationResource::class);
    }

    /**
     * @OA\Get(
     *     path="/api/client/my-solicitations/{mySolicitationId}",
     *     operationId="Show a Solicitation Data",
     *     tags={"My Solicitations"},
     *     summary="Show the data of a solicitation",
     *     description="Show the data of a solicitation",
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
     *      @OA\Response(
     *          response=200,
     *          description="Successfully retrieve a solicitation data",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ShowSolicitationResponse")
     *      ),
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
    public function show(Solicitation $mySolicitation)
    {
        $mySolicitation->loadMissing('category');

        return SolicitationResource::make($mySolicitation);
    }

    public function store(SolicitationRequest $request)
    {
        $data = SolicitationData::validateAndCreate([
            ...$request->validated(),
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

    public function update(SolicitationRequest $request, Solicitation $mySolicitation)
    {
        $data = SolicitationData::validateAndCreate([
            ...$request->validated(),
            'userSolicitationData' => [
                'status' => $mySolicitation->status,
                'likesAmount' => $mySolicitation->likes_amount,
                'solicitationId' => $mySolicitation->id,
                'userId' => current_user()->id,
                'actionDescription' => SolicitationActionDescriptionEnum::UPDATED,
            ],
        ]);

        $mySolicitation = app(UpdateSolicitationStrategy::class)
            ->execute($data, $mySolicitation);

        return $this->show($mySolicitation);
    }

    /**
     * @OA\Delete(
     *     path="/api/client/my-solicitations/{mySolicitationId}",
     *     operationId="Delete Solicitation",
     *     tags={"My Solicitations"},
     *     summary="Delete a solicitation",
     *     description="Delete a solicitation",
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
     *      @OA\Response(
     *          response=204,
     *          description="Successfully deleted a solicitation",
     *      ),
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
    public function destroy(Solicitation $mySolicitation)
    {
        $data = UserSolicitationData::from([
            'solicitationId' => $mySolicitation->id,
            'userId' => current_user()->id,
            'status' => $mySolicitation->status,
            'actionDescription' => SolicitationActionDescriptionEnum::DELETED,
        ]);

        app(DeleteSolicitationStrategy::class)
            ->execute($data);

        return response()->noContent();
    }
}
