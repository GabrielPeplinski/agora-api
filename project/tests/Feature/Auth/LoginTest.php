<?php

namespace Tests\Feature\Auth;

use App\Domains\Account\Models\User;
use App\Http\Api\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Hash;
use Tests\Cases\TestCaseFeature;

class LoginTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->useActionsFromController(LoginController::class);

        $this->user = User::factory()
            ->create([
                'email' => 'test@email.com',
                'password' => Hash::make('12345678'),
            ]);
    }

    private function getLoginResponseStructure(): array
    {
        return [
            'message',
            'tokenType',
            'token',
        ];
    }

    public function test_should_login_using_correct_credentials(): void
    {
        $data = [
            'email' => 'test@email.com',
            'password' => '12345678',
        ];

        $this->postJson($this->controllerAction(), $data)
            ->assertSuccessful()
            ->assertJsonStructure($this->getLoginResponseStructure());

        $this->assertAuthenticatedAs($this->user);
    }

    public function test_should_not_login_when_data_is_invalid(): void
    {
        $data = [
            'email' => 'wrong@email.com',
            'password' => '12345678',
        ];

        $this->postJson($this->controllerAction(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }
}
