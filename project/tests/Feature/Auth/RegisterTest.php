<?php

namespace Feature\Auth;

use App\Http\Api\Controllers\Auth\RegisterController;
use Tests\Cases\TestCaseFeature;

class RegisterTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->useActionsFromController(RegisterController::class);
    }

    public function test_should_register_new_user_when_data_is_valid()
    {
        $data = [
            'name' => 'New User',
            'email' => 'user@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->postJson($this->controllerAction(), $data)
            ->assertCreated();
    }
}
