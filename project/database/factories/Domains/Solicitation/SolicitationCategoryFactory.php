<?php

namespace Database\Factories\Domains\Solicitation;

use App\Domains\Solicitation\Models\SolicitationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitationCategoryFactory extends Factory
{
    protected $model = SolicitationCategory::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(4),
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
