<?php

namespace Tests\Feature\Client\UserSolicitation;

use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Controllers\Client\UserSolicitation\AddUserSolicitationImageController;
use Tests\Cases\TestCaseFeature;

class AddUserSolicitationImageTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loginAsClient();
        $this->useActionsFromController(AddUserSolicitationImageController::class);
    }

    public function test_should_not_image_and_return_exception_when_user_solicitation_action_description_its_not_status_updated()
    {
        $solicitation = Solicitation::factory()
            ->makeCurrentUserSolicitations()
            ->create();

        $userSolicitation = $solicitation->userSolicitations()->first();

        $this->postJson($this->controllerAction(null, $userSolicitation->id))
            ->assertUnprocessable()
            ->assertJson([
                'message' => __('custom.invalid_action_description_to_add_image'),
            ]);
    }
}
