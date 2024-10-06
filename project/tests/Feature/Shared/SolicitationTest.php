<?php

namespace Tests\Feature\Shared;

use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Models\SolicitationCategory;
use App\Http\Api\Controllers\Shared\SolicitationController;
use Tests\Cases\TestCaseFeature;

class SolicitationTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->useActionsFromController(SolicitationController::class);
    }

    private function getSolicitationResourceData(): array
    {
        return [
            'id',
            'title',
            'likesCount',
            'coverImage',
            'hasCurrentUserLike',
            'createdAt',
            'updatedAt',
        ];
    }

    private function getShowSolicitationResourceData(): array
    {
        return [
            'id',
            'title',
            'description',
            'latitudeCoordinates',
            'longitudeCoordinates',
            'status',
            'likesCount',
            'coverImage',
            'images',
            'solicitationCategory',
            'createdAt',
            'updatedAt',
        ];
    }

    public function test_should_return_no_solicitations_when_database_is_empty()
    {
        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(0, 'data');

        $this->assertCount(0, Solicitation::all());
    }

    public function test_should_return_all_solicitations()
    {
        Solicitation::factory()
            ->count(3)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);

        $this->assertCount(3, Solicitation::all());
    }

    public function test_should_return_404_when_solicitation_does_not_exists()
    {
        $this->getJson($this->controllerAction('show', ['solicitation' => 1]))
            ->assertNotFound();

        $this->assertDatabaseMissing(Solicitation::class, ['id' => 1]);
    }

    public function test_should_return_a_solicitation_when_data_is_valid()
    {
        $solicitation = Solicitation::factory()
            ->create();

        $this->getJson($this->controllerAction('show', ['solicitation' => $solicitation->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getShowSolicitationResourceData(),
            ]);

        $this->assertDatabaseHas(Solicitation::class, ['id' => $solicitation->id]);
    }

    public function test_should_return_solicitations_and_filter_by_status()
    {
        Solicitation::factory()
            ->create([
                'current_status' => SolicitationStatusEnum::OPEN,
            ]);

        Solicitation::factory()
            ->create([
                'current_status' => SolicitationStatusEnum::IN_PROGRESS,
            ]);

        Solicitation::factory()
            ->create([
                'current_status' => SolicitationStatusEnum::RESOLVED,
            ]);

        $this->getJson($this->controllerAction('index', ['filter[status]' => SolicitationStatusEnum::OPEN]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);

        $this->getJson($this->controllerAction('index', ['filter[status]' => SolicitationStatusEnum::IN_PROGRESS]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);

        $this->getJson($this->controllerAction('index', ['filter[status]' => SolicitationStatusEnum::RESOLVED]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);

        $this->assertCount(3, Solicitation::all());
    }

    public function test_should_return_solicitations_and_filter_by_solicitation_category()
    {
        $category = SolicitationCategory::factory()
            ->create();

        Solicitation::factory()
            ->count(2)
            ->create();

        $solicitation = Solicitation::factory()
            ->create([
                'solicitation_category_id' => $category->id,
            ]);

        $this->getJson($this->controllerAction('index', ['filter[solicitation_category_id]' => $solicitation->solicitation_category_id]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);

        $this->assertCount(3, Solicitation::all());
    }
}
