<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Strategies\Solicitation\UpdateSolicitationStatusStrategy;
use App\Http\Api\Request\Client\Solicitation\UpdateSolicitationStatusRequest;
use App\Http\Shared\Controllers\Controller;

class UpdateSolicitationStatusController extends Controller
{
    public function __invoke(UpdateSolicitationStatusRequest $request, Solicitation $solicitation)
    {
        $validated = $request->validated();

        $data = UserSolicitationData::validateAndCreate([
            'status' => $validated['status'],
            'solicitationId' => $solicitation->id,
            'userId' => current_user()->id,
            'actionDescription' => SolicitationActionDescriptionEnum::STATUS_UPDATED,
        ]);

        app(UpdateSolicitationStatusStrategy::class)
            ->execute($data);
    }
}
