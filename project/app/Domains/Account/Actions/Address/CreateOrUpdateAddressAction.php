<?php

namespace App\Domains\Account\Actions\Address;

use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Models\Address;

class CreateOrUpdateAddressAction
{
    public function execute(AddressData $data): Address
    {
        $data = array_keys_as($data->toArray(), [
            'zipCode' => 'zip_code',
            'cityName' => 'city_name',
            'addressCityId' => 'city_id',
            'userId' => 'user_id',
        ]);

        return Address::updateOrCreate([
            'user_id' => $data['user_id'],
        ], $data);
    }
}
