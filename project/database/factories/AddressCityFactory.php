<?php

namespace Database\Factories;

use App\Domains\Account\Models\AddressCity;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressCityFactory extends Factory
{
    public $model = AddressCity::class;

    public function definition(): array
    {
        return [
            'name' => 'Guarapuava',
            'state_id' => 16,
        ];
    }
}
