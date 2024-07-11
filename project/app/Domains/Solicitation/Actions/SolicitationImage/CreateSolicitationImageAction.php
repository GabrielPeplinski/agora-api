<?php

namespace App\Domains\Solicitation\Actions\SolicitationImage;

use App\Domains\Solicitation\Dtos\SolicitationImageData;
use App\Domains\Solicitation\Models\SolicitationImage;

class CreateSolicitationImageAction
{
    public function execute(SolicitationImageData $data): SolicitationImage
    {
        $data = [
            'solicitation_id' => $data->solicitationId,
            'file_name' => $data->fileName,
            'file_path' => $data->filePath,
            'is_cover_image' => $data->isCoverImage,
        ];

        return app(SolicitationImage::class)
            ->create($data);
    }
}
