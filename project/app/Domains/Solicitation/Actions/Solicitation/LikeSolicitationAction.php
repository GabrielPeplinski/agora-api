<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Account\Models\User;
use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\DB;

class LikeSolicitationAction
{
    public function execute(User $user, Solicitation $solicitation): void
    {
        try {
            DB::beginTransaction();

            $this->updateSolicitationLikesCount($solicitation);

            $data = $this->createSolicitationDto($user, $solicitation);

            app(CreateUserSolicitationAction::class)
                ->execute($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    private function createSolicitationDto(User $user, Solicitation $solicitation): SolicitationData
    {
        return SolicitationData::from([
            'solicitationId' => $solicitation->id,
            'userId' => $user->id,
            'actionDescription' => SolicitationActionDescriptionEnum::LIKE,
        ]);
    }

    private function updateSolicitationLikesCount(Solicitation $solicitation): void
    {
        $solicitation->likes_count += 1;
        $solicitation->save();
    }
}
