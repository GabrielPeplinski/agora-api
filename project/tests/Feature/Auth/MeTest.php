<?php

namespace Tests\Feature\Auth;

use App\Http\Api\Controllers\Auth\MeController;
use Tests\Cases\TestCaseFeature;

class MeTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->useActionsFromController(MeController::class);
    }

    private function getMeResponseStructure(): array
    {
        return [
            'name',
            'email',
            'created_at',
            'updated_at',
        ];
    }

    public function test_should_return_current_user_data()
    {
        $this->loginAsClient();

        $this->getJson($this->controllerAction())
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->getMeResponseStructure(),
            ]);
    }

    public function test_should_not_return_current_user_data_when_no_user_authenticated()
    {
        $this->getJson($this->controllerAction())
            ->assertStatus(401);
    }
}
