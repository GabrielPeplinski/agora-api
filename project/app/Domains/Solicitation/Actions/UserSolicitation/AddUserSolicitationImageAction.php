<?php

namespace App\Domains\Solicitation\Actions\UserSolicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Exceptions\CannotAddUserSolicitationImageException;
use App\Domains\Solicitation\Models\UserSolicitation;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;

class AddUserSolicitationImageAction
{
    public function execute(UserSolicitation $userSolicitation, File $tempImageFile): void
    {
        try {
            if ($userSolicitation->action_description !== SolicitationActionDescriptionEnum::STATUS_UPDATED) {
                throw new CannotAddUserSolicitationImageException();
            }

            DB::beginTransaction();

            $userSolicitation->addMedia($tempImageFile)
                ->toMediaCollection('image');

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            throw $error;
        }
    }
}
