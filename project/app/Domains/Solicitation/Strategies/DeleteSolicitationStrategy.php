<?php

namespace App\Domains\Solicitation\Strategies;

use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use Illuminate\Support\Facades\DB;

class DeleteSolicitationStrategy
{
    public function execute(UserSolicitationData $data): void
    {
        try {
            DB::beginTransaction();

            app(CreateUserSolicitationAction::class)
                ->execute($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
