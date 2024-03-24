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
    public function show(Solicitation $solicitation): SolicitationResource
    {
        $solicitation->loadMissing('solicitationCategory');

        return SolicitationResource::make($solicitation);
    }

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

    public function destroy(Solicitation $solicitation): Response
    {
        app(DeleteSolicitationAction::class)
            ->execute($solicitation);

        return response()->noContent();
    }
}
