<?php

namespace App\Http\Api\Controllers\Client;

use App\Domains\Solicitation\Actions\Solicitation\CreateSolicitationAction;
use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Request\Client\SolicitationRequest;
use App\Http\Shared\Controllers\Controller;

class SolicitationController extends Controller
{
    public function store(SolicitationRequest $request)
    {
        $this->authorize('create', Solicitation::class);

        $data = SolicitationData::validateAndCreate([
            ...$request->validated(),
            'status' => SolicitationStatusEnum::OPEN,
        ]);

        app(CreateSolicitationAction::class)
            ->execute($data);
    }
}
