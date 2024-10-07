<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Models\Solicitation;

class UpdateSolicitationStatusAction
{
    public function execute(UserSolicitationData $data, Solicitation $solicitation): Solicitation
    {
        $solicitation->update([
            'current_status' => $data->status,
        ]);

        return $solicitation;
    }
}
