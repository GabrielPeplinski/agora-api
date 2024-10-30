<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Exceptions\CannotUpdateSolicitationException;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Strategies\Solicitation\UpdateSolicitationStatusStrategy;
use App\Http\Api\Request\Client\Solicitation\UpdateSolicitationStatusRequest;
use App\Http\Api\Resources\Shared\Solicitation\UserSolicitationResource;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class UpdateSolicitationStatusController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/client/my-solicitations/{mySolicitationId}/status",
     *     operationId="Update a Solicitation Status",
     *     tags={"My Solicitations"},
     *     summary="Update a solicitation status",
     *     description="Update a current user's solicitation status.",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 type="string",
     *                 default="in_progress",
     *                 description="The new status of the solicitation",
     *                 property="status",
     *                 enum={"open", "in_progress", "resolved"},
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully update a solicitation status",
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
    public function __invoke(UpdateSolicitationStatusRequest $request, Solicitation $mySolicitation)
    {
        $this->authorize('updateStatus', $mySolicitation);

        try {
            $validated = $request->validated();

            $data = UserSolicitationData::validateAndCreate([
                'status' => $validated['status'],
                'solicitationId' => $mySolicitation->id,
                'userId' => current_user()->id,
                'actionDescription' => SolicitationActionDescriptionEnum::STATUS_UPDATED,
            ]);

            $userSolicitation = app(UpdateSolicitationStatusStrategy::class)
                ->execute($data, $mySolicitation);

            return UserSolicitationResource::make($userSolicitation);
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
}
