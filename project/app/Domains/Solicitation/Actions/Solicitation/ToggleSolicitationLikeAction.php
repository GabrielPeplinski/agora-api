<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Account\Models\User;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\DB;

class ToggleSolicitationLikeAction
{
    public function execute(User $user, Solicitation $solicitation): void
    {
        try {
            DB::beginTransaction();

            if (!$this->checkIfUserLikedSolicitation($user, $solicitation)) {
                app(LikeSolicitationAction::class)
                    ->execute($user, $solicitation);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    private function checkIfUserLikedSolicitation(User $user, Solicitation $solicitation): bool
    {
        return $solicitation
            ->likes()
            ->where('user_id', $user->id)
            ->exists();
    }
}
