<?php

namespace App\Domains\Solicitation\Actions\UserSolicitation;

use App\Domains\Solicitation\Models\UserSolicitation;

class DeleteUserSolicitationAction
{
    public function execute(UserSolicitation $userSolicitation): bool
    {
        return $userSolicitation->delete();
    }
}
