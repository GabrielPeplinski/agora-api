<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Actions\UserSolicitation\DeleteUserSolicitationAction;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Models\UserSolicitation;
use Illuminate\Support\Facades\DB;

class DislikeSolicitationAction
{
    public function execute(UserSolicitationData $data, Solicitation $solicitation): void
    {
        try {
            DB::beginTransaction();

            $solicitationToUpdate = $this->findUserSolicitationToDestroy($data);

            app(DeleteUserSolicitationAction::class)
                ->execute($solicitationToUpdate);

            $solicitation->decrement('likes_count');

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    private function findUserSolicitationToDestroy(UserSolicitationData $data)
    {
        return UserSolicitation::where('solicitation_id', $data->solicitationId)
            ->where('user_id', $data->userId)
            ->where('action_description', SolicitationActionDescriptionEnum::LIKE)
            ->first();
    }
}
