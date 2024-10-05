<?php

namespace App\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Models\Solicitation;

class UpdateSolicitationAction
{
    public function execute(SolicitationData $data, Solicitation $solicitation): Solicitation
    {
        $data->currentStatus = $solicitation->current_status;
        $data = array_keys_as($data->toArray(), [
            'latitudeCoordinates' => 'latitude_coordinates',
            'longitudeCoordinates' => 'longitude_coordinates',
            'solicitationCategoryId' => 'solicitation_category_id',
            'currentStatus' => 'current_status',
        ]);

        $solicitation->update($data);

        return $solicitation;
    }
}
