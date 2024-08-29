<?php

namespace Tests\Feature\Auth;

use App\Http\Api\Controllers\Auth\UpdatePersonalDataController;
use Illuminate\Support\Facades\Hash;
use Tests\Cases\TestCaseFeature;

class UpdatePersonalDataTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->useActionsFromController(UpdatePersonalDataController::class);
        $this->loginAsClient();

        $this->currentUser = current_user();
        $this->clientUserPassword = '12345678';
    }

    public function test_should_update_personal_data_when_data_is_valid(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'newemail@gmail.com',
            'password' => $this->clientUserPassword,
        ];

        $this->putJson($this->controllerAction(), $data)
            ->assertOk()
            ->assertJson([
                'message' => __('auth.personal_data_updated_successfully'),
            ]);

        $this->assertEquals($data['name'], $this->currentUser->name);
        $this->assertEquals($data['email'], $this->currentUser->email);
    }

    public function test_should_not_update_personal_data_when_password_is_not_correct(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'newemail@gmail.com',
            'password' => '12121212',
        ];

        $this->putJson($this->controllerAction(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'password' => __('auth.invalid_current_user_password'),
            ]);
    }

    public function test_should_update_personal_data_and_password_when_data_is_valid(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'newemail@gmail.com',
            'password' => $this->clientUserPassword,
            'new_password' => '123456',
            'new_password_confirmation' => '123456',
        ];

        $this->putJson($this->controllerAction(), $data)
            ->assertOk()
            ->assertJson([
                'message' => __('auth.personal_data_updated_successfully'),
            ]);

        $this->currentUser->refresh();

        $this->assertEquals($data['name'], $this->currentUser->name);
        $this->assertEquals($data['email'], $this->currentUser->email);

        $this->assertTrue(Hash::check($data['new_password'], $this->currentUser->password));
    }
}
