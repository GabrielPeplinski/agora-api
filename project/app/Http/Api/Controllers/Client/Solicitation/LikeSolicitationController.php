<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Strategies\Solicitation\ToggleSolicitationLikeStrategy;
use App\Http\Api\Request\Client\Solicitation\LikeSolicitationRequest;
use App\Http\Shared\Controllers\Controller;

class LikeSolicitationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/client/solicitations/like",
     *     operationId="Like or Unlike a Solicitation",
     *     tags={"Solicitations"},
     *     summary="Like or unlike a solicitation",
     *     description="Like or unlike a solicitation",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 type="integer",
     *                 default="1",
     *                 description="A solicitation ID",
     *                 property="solicitationId"
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully liked or unliked a solicitation",
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
     *     )
     * )
     */
    public function __invoke(LikeSolicitationRequest $request)
    {
        $this->authorize('like', Solicitation::class);

        $data = $request->validated();

        $solicitation = app(Solicitation::class)
            ->findOrFail($data['solicitationId']);

        $data = UserSolicitationData::validateAndCreate([
            'status' => $solicitation->current_status,
            'solicitationId' => $solicitation->id,
            'userId' => current_user()->id,
            'actionDescription' => SolicitationActionDescriptionEnum::LIKE,
        ]);

        app(ToggleSolicitationLikeStrategy::class)
            ->execute(current_user(), $data, $solicitation);
    }
}
