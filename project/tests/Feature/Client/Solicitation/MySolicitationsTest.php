<?php

namespace Tests\Feature\Client\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Controllers\Client\Solicitation\MySolicitationsController;
use Illuminate\Database\Eloquent\Collection;
use Tests\Cases\TestCaseFeature;

class MySolicitationsTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loginAsClient();
        $this->useActionsFromController(MySolicitationsController::class);
    }

    private function getSolicitationResourceData(): array
    {
        return [
            'id',
            'description',
            'latitudeCoordinates',
            'longitudeCoordinates',
            'status',
            'createdAt',
            'updatedAt',
        ];
    }

    private function createCurrentUserSolicitation(): Collection
    {
        return Solicitation::factory()
            ->count(2)
            ->makeCurrentUserSolicitations()
            ->create();
    }

    private function updateSolicitationStatus(string $status): void
    {
        current_user()->userSolicitations()
            ->first()
            ->update(['status' => $status]);
    }

    public function test_should_return_only_current_user_solicitations()
    {
        $mySolicitations = $this->createCurrentUserSolicitation();

        Solicitation::factory();

        $this->getJson($this->controllerAction())
            ->assertOk()
            ->assertJsonCount($mySolicitations->count(), 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);
    }

    public function test_should_return_no_solicitations_with_current_user_does_not_have_any_solicitations_created()
    {
        $this->getJson($this->controllerAction())
            ->assertOk()
            ->assertJsonCount(0, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);
    }

    public function test_should_return_only_current_user_solicitations_and_filter_according_to_status()
    {
        $mySolicitations = $this->createCurrentUserSolicitation();

        /*
         * At this point, all solicitation are in 'open' status
         */
        $this->getJson($this->controllerAction(null, ['filter[status]' => SolicitationStatusEnum::OPEN]))
            ->assertOk()
            ->assertJsonCount($mySolicitations->count(), 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);

        /*
         * Update one solicitation to 'in_progress' status
         */
        $this->updateSolicitationStatus(SolicitationStatusEnum::IN_PROGRESS);

        $this->refreshDatabase();

        $this->getJson($this->controllerAction(null, ['filter[status]' => SolicitationStatusEnum::IN_PROGRESS]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);

        /*
         * Update one solicitation to 'resolved' status
         */
        $this->updateSolicitationStatus(SolicitationStatusEnum::RESOLVED);

        $this->refreshDatabase();

        $this->getJson($this->controllerAction(null, ['filter[status]' => SolicitationStatusEnum::RESOLVED]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);
    }
}
