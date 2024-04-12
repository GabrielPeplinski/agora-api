<?php

namespace App\Domains\Account\Strategies;

use App\Domains\Account\Actions\Address\CreateOrUpdateAddressAction;
use App\Domains\Account\Actions\AddressCity\FirstOrCreateAddressCityAction;
use App\Domains\Account\Actions\AddressState\GetAddressStateIdByAbbreviationAction;
use App\Domains\Account\Actions\User\UpdateUserAddressAction;
use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Models\Address;
use App\Domains\Account\Models\User;
use Illuminate\Support\Facades\DB;

class CreateAddressStrategy
{
    private ?AddressData $data;

    private ?User $currentUser;

    public function __construct(AddressData $data, User $currentUser)
    {
        $this->data = $data;
        $this->currentUser = $currentUser;
    }

    public function execute(): ?Address
    {
        try {
            DB::beginTransaction();

            $this->getAddressStateId($this->data);

            $this->getAddressCity($this->data);

            $address = app(CreateOrUpdateAddressAction::class)
                ->execute($this->data);

            app(UpdateUserAddressAction::class)
                ->execute($this->currentUser, $address->id);

            DB::commit();

            return $address;
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            throw new \Exception('Ocorreu um erro ao tentar cadastrar seu endereço');
        }
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
