<?php

namespace App\Domains\Account\Actions\AddressCity;

use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Models\AddressCity;

class FirstOrCreateAddressCityAction
{
    public function execute(AddressData $data): AddressCity
    {
        $data = array_keys_as($data->toArray(), [
            'cityName' => 'name',
            'addressStateId' => 'state_id',
        ]);

        return AddressCity::firstOrCreate([
            'state_id' => $data['state_id'],
            'name' => $data['name'],
        ], $data);
    }
}