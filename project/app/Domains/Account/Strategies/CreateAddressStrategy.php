<?php

namespace App\Domains\Account\Strategies;

use App\Domains\Account\Actions\Address\CreateOrUpdateAddressAction;
use App\Domains\Account\Actions\AddressCity\FirstOrCreateAddressCityAction;
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

            $this->getAddressStateId($this->data);

            $this->getAddressCity($this->data);

            $address = app(CreateOrUpdateAddressAction::class)
                ->execute($this->data);

            DB::commit();

            return $address;
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
        }

        return null;
    }

    private function getAddressStateId(AddressData $data): void
    {
        $stateId = app(GetAddressStateIdByAbbreviationAction::class)
            ->execute($data->stateAbbreviation);

        $this->data->addressStateId = $stateId;
    }

    private function getAddressCity(AddressData $data): void
    {
        $city = app(FirstOrCreateAddressCityAction::class)
            ->execute($data);

        $this->data->addressCityId = $city->id;
    }
}
