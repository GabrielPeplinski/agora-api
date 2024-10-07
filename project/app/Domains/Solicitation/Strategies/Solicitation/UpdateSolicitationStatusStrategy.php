<?php

namespace App\Domains\Solicitation\Strategies\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\UpdateSolicitationStatusAction;
use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Exceptions\CannotUpdateSolicitationException;
use App\Domains\Solicitation\Models\Solicitation;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateSolicitationStatusStrategy
{
    /**
     * @throws Exception|CannotUpdateSolicitationException
     */
    public function execute(UserSolicitationData $data, Solicitation $solicitation): void
    {
        try {
            DB::beginTransaction();

            if ($solicitation->current_status === SolicitationStatusEnum::RESOLVED) {
                throw new CannotUpdateSolicitationException;
            }

            app(CreateUserSolicitationAction::class)
                ->execute($data);

            app(UpdateSolicitationStatusAction::class)
                ->execute($data, $solicitation);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
