<?php

namespace Database\Factories\Domains\Account;

use App\Domains\Account\Models\AddressCity;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressCityFactory extends Factory
{
    public $model = AddressCity::class;

    public function definition(): array
    {
        return [
            'name' => 'Guarapuava',
            'address_state_id' => 16,
        ];
    }
}
