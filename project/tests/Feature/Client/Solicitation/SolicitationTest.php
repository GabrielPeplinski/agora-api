<?php

namespace Tests\Feature\Client\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Models\SolicitationCategory;
use App\Domains\Solicitation\Models\UserSolicitation;
use App\Http\Api\Controllers\Client\Solicitation\SolicitationController;
use Tests\Cases\TestCaseFeature;

class SolicitationTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loginAsClient();
        $this->useActionsFromController(SolicitationController::class);
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
