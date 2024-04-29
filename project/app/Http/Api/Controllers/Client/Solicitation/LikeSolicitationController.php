<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\LikeSolicitationAction;
use App\Domains\Solicitation\Models\Solicitation;

class LikeSolicitationController
{
    public function __invoke(Solicitation $solicitation)
    {
        app(LikeSolicitationAction::class)
            ->execute(current_user(), $solicitation);
    }
}
