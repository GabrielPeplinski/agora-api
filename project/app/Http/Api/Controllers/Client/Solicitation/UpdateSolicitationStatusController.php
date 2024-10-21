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
