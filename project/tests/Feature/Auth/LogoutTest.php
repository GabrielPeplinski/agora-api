<?php

namespace Feature\Auth;

use App\Http\Api\Controllers\Auth\LogoutController;
use Tests\Cases\TestCaseFeature;

class LogoutTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->useActionsFromController(LogoutController::class);
    }

    public function test_should_logout_current_user()
    {
        $this->loginAsClient();

        $this->deleteJson($this->controllerAction())
            ->assertNoContent();
    }

    public function test_should_not_logout_when_there_is_no_current_user()
    {
        $this->deleteJson($this->controllerAction())
            ->assertStatus(401);
    }
}
