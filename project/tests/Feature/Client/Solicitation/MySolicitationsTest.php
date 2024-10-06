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
            'title',
            'likesCount',
            'coverImage',
            'hasCurrentUserLike',
            'status',
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

    private function createCurrentUserSolicitation(): Collection
    {
        return Solicitation::factory()
            ->count(2)
            ->makeCurrentUserSolicitations()
            ->create();
    }

    private function updateSolicitationStatus(Solicitation $solicitation, string $status): void
    {
        UserSolicitation::create([
            'solicitation_id' => $solicitation->id,
            'user_id' => current_user()->id,
            'status' => $status,
            'action_description' => SolicitationActionDescriptionEnum::STATUS_UPDATED,
        ]);

        $solicitation
            ->update([
                'current_status' => $status,
            ]);
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

    public function test_should_return_only_current_user_solicitations_and_filter_according_to_status_in_progress()
    {
        $this->createCurrentUserSolicitation();
        $currentUserFirstSolicitation = Solicitation::whereHas('userSolicitations', function ($query) {
            $query->where('user_id', current_user()->id)
                ->where('action_description', SolicitationActionDescriptionEnum::CREATED);
        })->first();

        /*
         * Update one solicitation to 'in_progress' status
         */
        $this->updateSolicitationStatus($currentUserFirstSolicitation, SolicitationStatusEnum::IN_PROGRESS);

        $this->refreshDatabase();

        $this->getJson($this->controllerAction('index', ['filter[status]' => SolicitationStatusEnum::IN_PROGRESS]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);

        $this->assertEquals(SolicitationStatusEnum::IN_PROGRESS, $currentUserFirstSolicitation->current_status);
    }

    public function test_should_return_only_current_user_solicitations_and_filter_according_to_status_resolved()
    {
        $this->createCurrentUserSolicitation();
        $currentUserFirstSolicitation = Solicitation::whereHas('userSolicitations', function ($query) {
            $query->where('user_id', current_user()->id)
                ->where('action_description', SolicitationActionDescriptionEnum::CREATED);
        })->first();

        /*
         * Update one solicitation to 'resolved' status
         */
        $this->updateSolicitationStatus($currentUserFirstSolicitation, SolicitationStatusEnum::RESOLVED);

        $this->refreshDatabase();

        $this->getJson($this->controllerAction('index', ['filter[status]' => SolicitationStatusEnum::RESOLVED]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationResourceData()],
            ]);

        $this->assertEquals(SolicitationStatusEnum::RESOLVED, $currentUserFirstSolicitation->current_status);
    }

    public function test_should_create_solicitation_when_data_is_valid(): void
    {
        $solicitationCategory = SolicitationCategory::factory()
            ->create();

        $data = [
            'title' => 'Solicitation title',
            'solicitationCategoryId' => $solicitationCategory->id,
            'description' => 'Solicitation description',
            'latitudeCoordinates' => '-25.0000',
            'longitudeCoordinates' => '-49.0000',
        ];

        $this->postJson($this->controllerAction('store'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getShowSolicitationResourceData(),
            ]);

        $this->assertDatabaseHas(Solicitation::class, [
            'title' => $data['title'],
            'description' => $data['description'],
            'latitude_coordinates' => $data['latitudeCoordinates'],
            'longitude_coordinates' => $data['longitudeCoordinates'],
            'solicitation_category_id' => $solicitationCategory->id,
            'current_status' => SolicitationStatusEnum::OPEN,
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

    public function test_should_create_and_update_solicitation_without_updating_status_when_data_is_valid(): void
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
                'data' => $this->getShowSolicitationResourceData(),
            ]);

        $this->assertDatabaseHas(Solicitation::class, [
            'title' => $data['title'],
            'description' => $data['description'],
            'latitude_coordinates' => $data['latitudeCoordinates'],
            'longitude_coordinates' => $data['longitudeCoordinates'],
            'solicitation_category_id' => $solicitationCategory->id,
            'current_status' => SolicitationStatusEnum::OPEN,
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
                'data' => $this->getShowSolicitationResourceData(),
            ]);

        $solicitation->refresh();

        $this->assertEquals($data['title'], $solicitation->title);
        $this->assertEquals($data['description'], $solicitation->description);
        $this->assertEquals($data['latitudeCoordinates'], $solicitation->latitude_coordinates);
        $this->assertEquals($data['longitudeCoordinates'], $solicitation->longitude_coordinates);
        $this->assertEquals($solicitationCategory->id, $solicitation->solicitation_category_id);
        $this->assertEquals(SolicitationStatusEnum::OPEN, $solicitation->current_status);

        $this->assertEquals(2, $solicitation->userSolicitations()->count());
    }

    public function test_should_delete_a_solicitation_when_it_belongs_to_the_current_user()
    {
        $solicitation = Solicitation::factory()
            ->makeCurrentUserSolicitations()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $solicitation->id))
            ->assertNoContent();

        $this->assertDatabaseMissing(Solicitation::class, [
            'id' => $solicitation->id,
        ]);

        $this->assertDatabaseMissing(UserSolicitation::class, [
            'solicitation_id' => $solicitation->id,
        ]);
    }

    public function test_should_not_delete_a_solicitation_when_its_status_is_already_updated_once()
    {
        $solicitation = Solicitation::factory()
            ->makeCurrentUserSolicitations()
            ->create();

        UserSolicitation::create([
            'solicitation_id' => $solicitation->id,
            'user_id' => current_user()->id,
            'status' => SolicitationStatusEnum::IN_PROGRESS,
            'action_description' => SolicitationActionDescriptionEnum::STATUS_UPDATED,
        ]);

        $this->deleteJson($this->controllerAction('destroy', $solicitation->id))
            ->assertStatus(422)
            ->assertJson([
                'message' => __('custom.cannot_delete_solicitation'),
            ]);

        $this->assertDatabaseHas(Solicitation::class, [
            'id' => $solicitation->id,
        ]);

        $this->assertDatabaseHas(UserSolicitation::class, [
            'solicitation_id' => $solicitation->id,
        ]);
    }
}
