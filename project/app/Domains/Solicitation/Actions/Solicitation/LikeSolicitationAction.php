<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\DB;

class LikeSolicitationAction
{
    public function execute(UserSolicitationData $data, Solicitation $solicitation): void
    {
        try {
            DB::beginTransaction();

            $this->updateSolicitationLikesCount($solicitation);

            app(CreateUserSolicitationAction::class)
                ->execute($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    private function updateSolicitationLikesCount(Solicitation $solicitation): void
    {
        $solicitation->likes_count += 1;
        $solicitation->save();
    }
}
