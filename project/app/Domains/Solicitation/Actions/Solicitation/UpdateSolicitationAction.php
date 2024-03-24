<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Models\Solicitation;

class UpdateSolicitationAction
{
    public function execute(SolicitationData $data, Solicitation $solicitation): Solicitation
    {
        $data = array_keys_as($data->toArray(), [
            'latitudeCoordinate' => 'latitude_coordinate',
            'longitudeCoordinate' => 'longitude_coordinate',
            'solicitationCategoryId' => 'solicitation_category_id',
            'userId' => 'user_id',
        ]);

        $solicitation->update($data);

        return $solicitation;
    }
}
