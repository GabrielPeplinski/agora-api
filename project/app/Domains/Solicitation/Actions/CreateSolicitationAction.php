<?php

namespace App\Domains\Solicitation\Actions;

use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Models\Solicitation;

class CreateSolicitationAction
{
    public function execute(SolicitationData $data): Solicitation
    {
        $data = array_keys_as($data->toArray(), [
            'latitudeCoordinates' => 'latitude_coordinates',
            'longitudeCoordinates' => 'longitude_coordinates',
        ]);

        return app(Solicitation::class)
            ->create($data);
    }
}
