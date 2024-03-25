<?php

namespace App\Http\Api\Controllers\Client;

use App\Domains\Solicitation\Actions\Solicitation\CreateSolicitationAction;
use App\Domains\Solicitation\Actions\Solicitation\DeleteSolicitationAction;
use App\Domains\Solicitation\Actions\Solicitation\UpdateSolicitationAction;
use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Request\Client\SolicitationRequest;
use App\Http\Api\Resources\Client\SolicitationResource;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\Response;

class SolicitationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/client/solicitations/{solicitationId}",
     *     operationId="Show a Solicitation Data",
     *     tags={"Solicitations"},
     *     summary="Show the data of a solicitation",
     *     description="Show the data of a solicitation",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *          name="solicitationId",
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
     *         @OA\JsonContent(ref="#/components/schemas/SolicitationResponse")
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
    public function show(Solicitation $solicitation): SolicitationResource
    {
        $solicitation->loadMissing('solicitationCategory');

        return SolicitationResource::make($solicitation);
    }

    /**
     * @OA\Post(
     *     path="/api/client/solicitations",
     *     operationId="Create a new Solicitation",
     *     tags={"Solicitations"},
     *     summary="Create a new Solicitation",
     *     description="Create a new Solicitation",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *
     *          @OA\JsonContent(ref="#/components/schemas/SolicitationRequest")
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Successfully registered a new solicitation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/SolicitationResponse")
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
    public function store(SolicitationRequest $request): SolicitationResource
    {
        $data = SolicitationData::validateAndCreate([
            ...$request->validated(),
            'status' => SolicitationStatusEnum::OPEN,
            'userId' => current_user()->id,
        ]);

        $solicitation = app(CreateSolicitationAction::class)
            ->execute($data);

        return $this->show($solicitation);
    }

    public function update(SolicitationRequest $request, Solicitation $solicitation): SolicitationResource
    {
        $data = SolicitationData::validateAndCreate([
            ...$request->validated(),
            'userId' => current_user()->id,
        ]);

        $solicitation = app(UpdateSolicitationAction::class)
            ->execute($data, $solicitation);

        return $this->show($solicitation);
    }

    /**
     * @OA\Delete(
     *     path="/api/client/solicitations/{solicitationId}",
     *     operationId="Delete Solicitation",
     *     tags={"Solicitations"},
     *     summary="Delete a solicitation",
     *     description="Delete a solicitation",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *          name="solicitationId",
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
    public function destroy(Solicitation $solicitation): Response
    {
        app(DeleteSolicitationAction::class)
            ->execute($solicitation);

        return response()->noContent();
    }
}
