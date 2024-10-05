<?php

namespace App\Domains\Solicitation\Strategies\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\UpdateSolicitationStatusAction;
use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\DB;

class UpdateSolicitationStatusStrategy
{
    /**
     * @throws \Exception
     */
    public function execute(UserSolicitationData $data, Solicitation $solicitation): void
    {
        try {
            DB::beginTransaction();

            app(CreateUserSolicitationAction::class)
                ->execute($data);

            app(UpdateSolicitationStatusAction::class)
                ->execute($data, $solicitation);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
