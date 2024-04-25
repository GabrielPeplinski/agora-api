<?php

namespace Database\Factories;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitationFactory extends Factory
{

    protected $model = Solicitation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'solicitation_category_id' => SolicitationCategoryFactory::factory()
                ->create(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'latitude_coordinates' => $this->faker->latitude(),
            'longitude_coordinates' => $this->faker->longitude(),
            'likes_amount' => $this->faker->randomNumber(3),
        ];
    }

    public function configure(): SolicitationFactory
    {
        return $this->afterCreating(function (Solicitation $solicitation) {
            $solicitation->userSolicitations()->create([
                'status' => SolicitationStatusEnum::OPEN,
                'action_description' => SolicitationActionDescriptionEnum::CREATED,
                'user_id' => UserFactory::create(),
            ]);
        });
    }

    public function makeCurrentUserSolicitation(): void
    {
        $this->afterCreating(function (Solicitation $solicitation) {
            $solicitation->userSolicitations()
                ->where('action_description', SolicitationActionDescriptionEnum::CREATED)
                ->update([
                    'user_id' => current_user()->id,
                ]);
        });
    }
}
