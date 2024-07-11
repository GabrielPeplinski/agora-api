<?php

namespace App\Domains\Solicitation\Strategies\SolicitationImage;

use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;

class AddSolicitationImageStrategy
{
    public function execute(Solicitation $solicitation, File $tempImageFile): void
    {
        try {
            DB::beginTransaction();

            $solicitation->loadMissing('media');

            $isCoverImage = $solicitation
                ->getMedia('coverImage')
                ->isEmpty();

            if ($isCoverImage) {
                $solicitation->addMedia($tempImageFile)
                    ->toMediaCollection('coverImage');
            } else {
                $solicitation->addMedia($tempImageFile)
                    ->toMediaCollection('images');
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            throw $error;
        }
    }
}
