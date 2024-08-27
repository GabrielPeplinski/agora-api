<?php

namespace Database\Factories\Domains\Account;

use App\Domains\Account\Models\Address;
use App\Domains\Account\Models\User;
use App\Domains\Shared\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(RolesEnum::ADMIN);
        });
    }

    public function client(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(RolesEnum::CLIENT);
        });
    }
}
