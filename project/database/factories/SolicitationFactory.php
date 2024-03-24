<?php

namespace Database\Factories;

use App\Domains\Account\Models\User;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Models\SolicitationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitationFactory extends Factory
{
    public $model = Solicitation::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(4),
            'title' => $this->faker->sentence(),
            'report' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([
                SolicitationStatusEnum::OPEN,
                SolicitationStatusEnum::IN_PROGRESS,
                SolicitationStatusEnum::RESOLVED,
            ]),
            'latitude_coordinate' => $this->faker->latitude(),
            'longitude_coordinate' => $this->faker->longitude(),
            'solicitation_category_id' => SolicitationCategory::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
