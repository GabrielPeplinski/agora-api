<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\ToggleSolicitationLikeAction;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Request\Solicitation\LikeSolicitationRequest;

class LikeSolicitationController
{
    public function __invoke(LikeSolicitationRequest $request)
    {
        $data = $request->validated();

        $solicitation = app(Solicitation::class)
            ->findOrFail($data['solicitationId']);

        app(ToggleSolicitationLikeAction::class)
            ->execute(current_user(), $solicitation);
    }
}
