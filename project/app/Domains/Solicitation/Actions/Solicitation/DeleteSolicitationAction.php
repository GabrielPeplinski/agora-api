<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Models\Solicitation;

class DeleteSolicitationAction
{
    public function execute(Solicitation $solicitation): bool
    {
        return $solicitation->delete();
    }
}
