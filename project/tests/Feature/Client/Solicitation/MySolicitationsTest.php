<?php

namespace Tests\Feature\Client\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Models\SolicitationCategory;
use App\Domains\Solicitation\Models\UserSolicitation;
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

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount($mySolicitations->count(), 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);
    }

    public function test_should_return_no_solicitations_with_current_user_does_not_have_any_solicitations_created()
    {
        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(0, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);
    }

    public function test_should_return_only_current_user_solicitations_and_filter_according_to_status_open()
    {
        $mySolicitations = $this->createCurrentUserSolicitation();

        /*
         * At this point, all solicitation are in 'open' status
         */
        $this->getJson($this->controllerAction('index', ['filter[status]' => SolicitationStatusEnum::OPEN]))
            ->assertOk()
            ->assertJsonCount($mySolicitations->count(), 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);
    }

    public function test_should_return_only_current_user_solicitations_and_filter_according_to_status_in_progress()
    {
        $this->createCurrentUserSolicitation();

        /*
         * Update one solicitation to 'in_progress' status
         */
        $this->updateSolicitationStatus(SolicitationStatusEnum::IN_PROGRESS);

        $this->refreshDatabase();

        $this->getJson($this->controllerAction('index', ['filter[status]' => SolicitationStatusEnum::IN_PROGRESS]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);
    }

    public function test_should_return_only_current_user_solicitations_and_filter_according_to_status_resolved()
    {
        $this->createCurrentUserSolicitation();

        /*
         * Update one solicitation to 'resolved' status
         */
        $this->updateSolicitationStatus(SolicitationStatusEnum::RESOLVED);

        $this->refreshDatabase();

        $this->getJson($this->controllerAction('index', ['filter[status]' => SolicitationStatusEnum::RESOLVED]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);
    }

    public function test_should_create_solicitation_when_data_is_valid(): void
    {
        $solicitationCategory = SolicitationCategory::factory()
            ->create();

        $data = [
            'title' => 'Solicitation title',
            'solicitationCategoryId' => $solicitationCategory->id,
            'description' => 'Solicitation description',
            'latitudeCoordinates' => '-25.4294',
            'longitudeCoordinates' => '-49.2719',
        ];

        $this->postJson($this->controllerAction('store'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getSolicitationResourceData(),
            ]);

        $this->assertDatabaseHas(Solicitation::class, [
            'title' => $data['title'],
            'description' => $data['description'],
            'latitude_coordinates' => $data['latitudeCoordinates'],
            'longitude_coordinates' => $data['longitudeCoordinates'],
            'solicitation_category_id' => $solicitationCategory->id,
        ]);

        $solicitation = Solicitation::first();

        $this->assertDatabaseHas(UserSolicitation::class, [
            'solicitation_id' => $solicitation->id,
            'user_id' => current_user()->id,
            'status' => SolicitationStatusEnum::OPEN,
            'action_description' => SolicitationActionDescriptionEnum::CREATED,
        ]);

        $this->assertTrue($solicitation->userSolicitations()->exists());
    }

    public function test_should_create_and_update_solicitation_when_data_is_valid(): void
    {
        $solicitationCategory = SolicitationCategory::factory()
            ->create();

        $data = [
            'title' => 'Solicitation title',
            'solicitationCategoryId' => $solicitationCategory->id,
            'description' => 'Solicitation description',
            'latitudeCoordinates' => '-25.4294',
            'longitudeCoordinates' => '-49.2719',
        ];

        $this->postJson($this->controllerAction('store'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getSolicitationResourceData(),
            ]);

        $this->assertDatabaseHas(Solicitation::class, [
            'title' => $data['title'],
            'description' => $data['description'],
            'latitude_coordinates' => $data['latitudeCoordinates'],
            'longitude_coordinates' => $data['longitudeCoordinates'],
            'solicitation_category_id' => $solicitationCategory->id,
        ]);

        $solicitation = Solicitation::first();

        $this->assertDatabaseHas(UserSolicitation::class, [
            'solicitation_id' => $solicitation->id,
            'user_id' => current_user()->id,
            'status' => SolicitationStatusEnum::OPEN,
            'action_description' => SolicitationActionDescriptionEnum::CREATED,
        ]);

        $this->assertTrue($solicitation->userSolicitations()->exists());

        $data = [
            'title' => 'Solicitation title updated',
            'solicitationCategoryId' => $solicitationCategory->id,
            'description' => 'Solicitation description updated',
            'latitudeCoordinates' => '-25.4294',
            'longitudeCoordinates' => '-49.2719',
        ];

        $this->putJson($this->controllerAction('update', $solicitation->id), $data)
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getSolicitationResourceData(),
            ]);

        $solicitation->refresh();

        $this->assertEquals($data['title'], $solicitation->title);
        $this->assertEquals($data['description'], $solicitation->description);
        $this->assertEquals($data['latitudeCoordinates'], $solicitation->latitude_coordinates);
        $this->assertEquals($data['longitudeCoordinates'], $solicitation->longitude_coordinates);
        $this->assertEquals($solicitationCategory->id, $solicitation->solicitation_category_id);

        $this->assertEquals(2, $solicitation->userSolicitations()->count());
    }
}
