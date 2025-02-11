<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\DB;

class ClearSolicitationHistoryAction
{
    public function execute(Solicitation $solicitation): void
    {
        try {
            DB::beginTransaction();

            $solicitation
                ->userSolicitations()
                ->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
