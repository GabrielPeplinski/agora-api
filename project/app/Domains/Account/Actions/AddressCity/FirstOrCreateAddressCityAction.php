<?php

namespace App\Domains\Account\Actions\AddressCity;

use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Models\AddressCity;

class FirstOrCreateAddressCityAction
{
    public function execute(AddressData $data): AddressCity
    {
        $data = [
            'name' => $data->cityName,
            'address_state_id' => $data->addressStateId,
        ];

        return AddressCity::firstOrCreate($data);
    }
}
