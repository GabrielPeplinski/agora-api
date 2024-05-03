<?php

namespace Tests\Feature\Client\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Controllers\Client\Solicitation\LikeSolicitationController;
use Tests\Cases\TestCaseFeature;

class LikeSolicitationTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loginAsClient();
        $this->useActionsFromController(LikeSolicitationController::class);
    }

    public function test_should_like_a_solicitation()
    {
        $solicitation  = Solicitation::factory()
            ->create();

        $this->postJson($this->controllerAction(), [
            'solicitationId' => $solicitation->id,
        ])->assertOk();

        $this->refreshDatabase();

        $this->assertDatabaseHas('user_solicitations', [
            'user_id' => current_user()->id,
            'solicitation_id' => $solicitation->id,
            'action_description' => SolicitationActionDescriptionEnum::LIKE,
        ]);
    }
}
