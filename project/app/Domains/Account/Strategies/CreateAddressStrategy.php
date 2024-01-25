<?php

namespace App\Domains\Account\Strategies;

use App\Domains\Account\Actions\Address\CreateAddressAction;
use App\Domains\Account\Actions\AddressCity\CreateAddressCityAction;
use App\Domains\Account\Actions\AddressState\GetAddressStateIdByAbbreviationAction;
use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Models\Address;
use Illuminate\Support\Facades\DB;

class CreateAddressStrategy
{
    private ?AddressData $data;

    public function __construct(AddressData $data)
    {
        $this->data = $data;
    }

    public function execute(): ?Address
    {
        try {
            DB::beginTransaction();

            $this->createAddressState($this->data);

            $this->createAddressCity($this->data);

            $address = app(CreateAddressAction::class)
                ->execute($this->data);

            DB::commit();

            return $address;
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
        }

        return null;
    }

    private function createAddressState(AddressData $data): void
    {
        $stateId = app(GetAddressStateIdByAbbreviationAction::class)
            ->execute($data->stateAbbreviation);

        $this->data->addressStateId = $stateId;
    }

    private function createAddressCity(AddressData $data): void
    {
        $city = app(CreateAddressCityAction::class)
            ->execute($data);

        $this->data->addressCityId = $city->id;
    }
}
