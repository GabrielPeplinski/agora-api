<?php

namespace Tests\Feature\Auth;

use App\Http\Api\Controllers\Auth\RegisterController;
use Tests\Cases\TestCaseFeature;

class RegisterTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->useActionsFromController(RegisterController::class);
    }

    private function getRegisterStructure(): array
    {
        return [
            'message',
            'name',
        ];
    }

    public function test_should_register_new_user_when_data_is_valid(): void
    {
        $data = [
            'name' => 'New User',
            'email' => 'user@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->postJson($this->controllerAction(), $data)
            ->assertCreated()
            ->assertJsonStructure($this->getRegisterStructure());

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function test_should_not_register_new_user_when_data_is_invalid(): void
    {
        $data = [
            'name' => 'New User',
            'email' => 'user@gmail.com',
            'password' => '12345678',
        ];

        $this->postJson($this->controllerAction(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors('password');

        $this->assertDatabaseMissing('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }
}
