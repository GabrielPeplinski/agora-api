<?php

namespace Tests\Feature\Auth;

use App\Http\Api\Controllers\Auth\UpdatePersonalDataController;
use Tests\Cases\TestCaseFeature;

class UpdatePersonalDataTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->useActionsFromController(UpdatePersonalDataController::class);
        $this->loginAsClient();
    }

    public function test_should_update_personal_data_when_data_is_valid(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'newemail@gmail.com',
        ];

        $this->putJson($this->controllerAction(), $data)
            ->assertOk()
            ->assertJson([
                'message' => 'Suas informações foram atualizadas com sucesso',
            ]);

        $currentUser = current_user();

        $this->assertEquals($data['name'], $currentUser->name);
        $this->assertEquals($data['email'], $currentUser->email);
    }
}
