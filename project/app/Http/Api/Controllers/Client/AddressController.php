<?php

namespace App\Http\Api\Controllers\Client;

use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Strategies\CreateAddressStrategy;
use App\Http\Api\Request\Client\AddressRequest;
use App\Http\Api\Resources\Client\AddressResource;
use App\Http\Shared\Controllers\Controller;

class AddressController extends Controller
{
    public function index()
    {
        current_user()->load('address.city.state');

        $address = current_user()->address;

        return AddressResource::make($address);
    }

    public function createOrUpdate(AddressRequest $request)
    {
        $data = AddressData::validateAndCreate([
            ...$request->validated(),
            'userId' => current_user()->id,
        ]);

        $address = (new CreateAddressStrategy($data))
            ->execute();

        return AddressResource::make($address);
    }
}
