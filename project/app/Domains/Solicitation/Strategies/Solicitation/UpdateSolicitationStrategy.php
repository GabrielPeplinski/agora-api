<?php

namespace App\Domains\Solicitation\Strategies\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\UpdateSolicitationAction;
use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Exceptions\CannotUpdateSolicitationException;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\DB;

class UpdateSolicitationStrategy
{
    public function execute(SolicitationData $data, Solicitation $solicitation): Solicitation
    {
        if ($solicitation->current_status === SolicitationStatusEnum::RESOLVED) {
            throw new CannotUpdateSolicitationException;
        }

        try {
            DB::beginTransaction();

            $solicitation = app(UpdateSolicitationAction::class)
                ->execute($data, $solicitation);

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
