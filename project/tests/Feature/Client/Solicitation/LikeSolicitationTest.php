<?php

namespace Tests\Feature\Client\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Models\UserSolicitation;
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
        $solicitation = Solicitation::factory()
            ->create([
                'likes_count' => 0,
            ]);

        $this->postJson($this->controllerAction(), [
            'solicitationId' => $solicitation->id,
        ])->assertOk();

        $this->refreshDatabase();

        $this->assertDatabaseHas(UserSolicitation::class, [
            'user_id' => current_user()->id,
            'solicitation_id' => $solicitation->id,
            'action_description' => SolicitationActionDescriptionEnum::LIKE,
        ]);

        $this->assertEquals(1, $solicitation->refresh()->likes_count);
    }

    public function test_should_like_and_dislike_a_solicitation()
    {
        $solicitation = Solicitation::factory()
            ->create([
                'likes_count' => 0,
            ]);

        $this->postJson($this->controllerAction(), ['solicitationId' => $solicitation->id])
            ->assertOk();

        $this->refreshDatabase();

        $this->assertDatabaseHas(UserSolicitation::class, [
            'user_id' => current_user()->id,
            'solicitation_id' => $solicitation->id,
            'action_description' => SolicitationActionDescriptionEnum::LIKE,
        ]);
        $this->assertEquals(1, $solicitation->refresh()->likes_count);

        $this->postJson($this->controllerAction(), [
            'solicitationId' => $solicitation->id,
        ])->assertOk();

        $this->refreshDatabase();

        $this->assertDatabaseMissing(UserSolicitation::class, [
            'user_id' => current_user()->id,
            'solicitation_id' => $solicitation->id,
            'action_description' => SolicitationActionDescriptionEnum::LIKE,
        ]);
        $this->assertEquals(0, $solicitation->refresh()->likes_count);
    }
}
