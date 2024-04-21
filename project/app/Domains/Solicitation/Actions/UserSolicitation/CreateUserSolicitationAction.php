<?php

namespace App\Domains\Solicitation\Actions\UserSolicitation;

use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Models\UserSolicitation;

class CreateUserSolicitationAction
{
    public function execute(SolicitationData $data): UserSolicitation
    {
        $data = [
            'status' => $data->status,
            'action_description' => $data->actionDescription,
            'solicitation_id' => $data->solicitationId,
            'user_id' => $data->userId,
        ];

        return app(UserSolicitation::class)
            ->create($data);
    }
}
