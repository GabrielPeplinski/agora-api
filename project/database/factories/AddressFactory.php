<?php

namespace Database\Factories;

use App\Domains\Account\Models\Address;
use App\Domains\Account\Models\AddressCity;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public $model = Address::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(4),
            'zip_code' => $this->faker->postcode(),
            'neighborhood' => $this->faker->streetName(),
            'address_city_id' => AddressCity::factory()->create()->id,
        ];
    }
}
