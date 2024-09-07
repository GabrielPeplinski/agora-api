<?php

namespace App\Domains\Solicitation\Strategies\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\ClearSolicitationHistoryAction;
use App\Domains\Solicitation\Actions\Solicitation\DeleteSolicitationAction;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Exceptions\CannotDeleteSolicitationException;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\DB;

class DeleteSolicitationStrategy
{
    public function execute(Solicitation $solicitation): void
    {
        try {
            $this->checkIfSolicitationCanBeDeleted($solicitation);

            DB::beginTransaction();

            $this->deleteSolicitationImages($solicitation);

            app(ClearSolicitationHistoryAction::class)
                ->execute($solicitation);

            app(DeleteSolicitationAction::class)
                ->execute($solicitation);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function checkIfSolicitationCanBeDeleted(Solicitation $solicitation): void
    {
        $hasStatusUpdated = $solicitation->userSolicitations()
            ->where('action_description', SolicitationActionDescriptionEnum::STATUS_UPDATED)
            ->exists();

        if ($hasStatusUpdated) {
            throw new CannotDeleteSolicitationException();
        }
    }

    private function deleteSolicitationImages(Solicitation $solicitation): void
    {
        $solicitation->clearMediaCollection('coverImage');
        $solicitation->clearMediaCollection('images');
    }
}
