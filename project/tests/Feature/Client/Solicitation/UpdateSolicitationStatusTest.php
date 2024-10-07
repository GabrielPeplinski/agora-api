<?php

namespace Tests\Feature\Client\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Models\UserSolicitation;
use App\Http\Api\Controllers\Client\Solicitation\UpdateSolicitationStatusController;
use Tests\Cases\TestCaseFeature;

class UpdateSolicitationStatusTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loginAsClient();
        $this->useActionsFromController(UpdateSolicitationStatusController::class);
    }

    public function test_should_update_a_solicitation_status_when_it_belongs_to_current_user()
    {
        $solicitation = Solicitation::factory()
            ->makeCurrentUserSolicitations()
            ->create();

        $data = [
            'status' => SolicitationStatusEnum::IN_PROGRESS,
        ];

        // Delay to avoid the same timestamp
        sleep(1);

        $this->putJson($this->controllerAction(null, $solicitation->id), $data)
            ->assertOk();

        $this->refreshDatabase();

        $this->assertDatabaseHas(UserSolicitation::class, [
            'user_id' => current_user()->id,
            'solicitation_id' => $solicitation->id,
            'action_description' => SolicitationActionDescriptionEnum::STATUS_UPDATED,
        ]);

        $this->assertEquals(SolicitationStatusEnum::IN_PROGRESS, $solicitation->refresh()->current_status);
    }

    public function test_should_not_update_a_solicitation_status_when_it_is_already_resolved()
    {
        $solicitation = Solicitation::factory()
            ->makeCurrentUserSolicitations()
            ->create();

        // Delay to avoid the same timestamp
        sleep(1);

        $solicitation->userSolicitations()->create([
            'user_id' => current_user()->id,
            'action_description' => SolicitationActionDescriptionEnum::STATUS_UPDATED,
            'status' => SolicitationStatusEnum::RESOLVED,
        ]);
        $solicitation->update([
            'current_status' => SolicitationStatusEnum::RESOLVED,
        ]);

        $data = [
            'status' => SolicitationStatusEnum::IN_PROGRESS,
        ];

        $this->putJson($this->controllerAction(null, $solicitation->id), $data)
            ->assertUnprocessable()
            ->assertJson([
                'message' => __('custom.cannot_update_solicitation'),
            ]);

        $this->refreshDatabase();

        $this->assertEquals(SolicitationStatusEnum::RESOLVED, $solicitation->refresh()->current_status);
    }

    public function test_should_not_update_a_solicitation_status_when_the_status_its_not_valid()
    {
        $solicitation = Solicitation::factory()
            ->makeCurrentUserSolicitations()
            ->create();

        $data = [
            'status' => 'invalid_status',
        ];

        $this->putJson($this->controllerAction(null, $solicitation->id), $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['status']);

        $this->refreshDatabase();

        $this->assertDatabaseMissing(UserSolicitation::class, [
            'user_id' => current_user()->id,
            'solicitation_id' => $solicitation->id,
            'action_description' => SolicitationActionDescriptionEnum::STATUS_UPDATED,
        ]);

        $this->assertNotEquals('invalid_status', $solicitation->refresh()->current_status);
    }
}
