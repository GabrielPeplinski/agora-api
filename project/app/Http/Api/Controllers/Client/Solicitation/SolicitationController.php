<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Strategies\CreateSolicitationStrategy;
use App\Domains\Solicitation\Strategies\UpdateSolicitationStrategy;
use App\Http\Api\Request\Client\SolicitationRequest;
use App\Http\Api\Resources\Client\Solicitation\SolicitationResource;

class SolicitationController
{
    public function show(Solicitation $solicitation)
    {
        $solicitation->loadMissing('category');

        return SolicitationResource::make($solicitation);
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

    public function update(SolicitationRequest $request, Solicitation $solicitation)
    {
        $data = SolicitationData::validateAndCreate([
            ...$request->validated(),
            'userSolicitationData' => [
                'status' => $solicitation->status,
                'likesAmount' => $solicitation->likes_amount,
                'solicitationId' => $solicitation->id,
                'userId' => current_user()->id,
                'actionDescription' => SolicitationActionDescriptionEnum::UPDATED,
            ],
        ]);

        $solicitation = app(UpdateSolicitationStrategy::class)
            ->execute($data, $solicitation);

        return $this->show($solicitation);
    }

    public function destroy(Solicitation $solicitation)
    {
        return response()->json([
            'message' => 'Solicitation deleted',
        ]);
    }
}
