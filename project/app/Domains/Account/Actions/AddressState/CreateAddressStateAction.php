<?php

namespace App\Domains\Account\Actions\AddressState;

use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Models\AddressState;

class CreateAddressStateAction
{
    public function execute(AddressData $data): AddressState
    {
        $data = array_keys_as($data->toArray(), [
            'stateName' => 'name',
            'stateAbbreviation' => 'name_abbreviation',
        ]);

       return AddressState::create($data);
    }
}
