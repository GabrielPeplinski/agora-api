<?php

namespace App\Domains\Account\Actions\Address;

use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Models\Address;

class CreateOrUpdateAddressAction
{
    public function execute(AddressData $data): Address
    {
        $data = [
            'zip_code' => $data->zipCode,
            'neighborhood' => $data->neighborhood,
            'address_city_id' => $data->addressCityId,
        ];

        return Address::updateOrCreate($data);
    }
}
