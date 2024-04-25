<?php

namespace Tests\Feature\Client\Solicitation;

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

    private function createCurrentUserSolicitation(): Collection
    {
        return Solicitation::factory()
            ->count(2)
            ->makeCurrentUserSolicitations()
            ->create();
    }
}
