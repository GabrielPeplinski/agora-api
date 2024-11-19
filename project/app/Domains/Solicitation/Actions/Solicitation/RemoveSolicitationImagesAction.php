<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Dtos\RemoveSolicitationImageData;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\DB;

class RemoveSolicitationImagesAction
{
    public function execute(Solicitation $solicitation, RemoveSolicitationImageData $data): void
    {
        try {
            DB::beginTransaction();

            $solicitation->loadMissing('media');

            foreach ($data->imageUrls as $imageUrl) {
                if ($solicitation->getFirstMediaUrl('coverImage') === $imageUrl) {
                    $solicitation->clearMediaCollection('coverImage');
                }
            }

            foreach ($solicitation->getMedia('images') as $media) {
                if (in_array($media->getFullUrl(), $data->imageUrls, true)) {
                    $media->delete();
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
