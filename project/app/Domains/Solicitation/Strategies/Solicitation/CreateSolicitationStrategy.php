<?php

namespace App\Domains\Solicitation\Strategies\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\CreateSolicitationAction;
use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\DB;

class CreateSolicitationStrategy
{
    public function execute(SolicitationData $data): Solicitation
    {
        try {
            DB::beginTransaction();

            $solicitation = app(CreateSolicitationAction::class)
                ->execute($data);

            $data->userSolicitationData->solicitationId = $solicitation->id;

            app(CreateUserSolicitationAction::class)
                ->execute($data->userSolicitationData);

            DB::commit();

            return $solicitation;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
