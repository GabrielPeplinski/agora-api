<?php

namespace App\Domains\Account\Actions\AddressCity;

use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Models\AddressCity;
use App\Support\AddressCityNameFormatter;

class FirstOrCreateAddressCityAction
{
    public function execute(AddressData $data): AddressCity
    {
        $data = [
            'name' => AddressCityNameFormatter::formatCityName($data->cityName),
            'address_state_id' => $data->addressStateId,
        ];

        return AddressCity::firstOrCreate($data);
    }
}
