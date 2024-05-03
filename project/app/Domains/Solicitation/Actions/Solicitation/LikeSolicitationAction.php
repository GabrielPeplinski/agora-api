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

            app(CreateUserSolicitationAction::class)
                ->execute($data);

            $solicitation->increment('likes_count');

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
