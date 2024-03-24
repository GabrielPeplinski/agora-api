<?php

namespace Tests\Feature\Client;

use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Models\SolicitationCategory;
use App\Http\Api\Controllers\Client\SolicitationController;
use Tests\Cases\TestCaseFeature;

class SolicitationTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loginAsClient();
        $this->useActionsFromController(SolicitationController::class);
    }

    private function getResponseStructure(): array
    {
        return [
            'id',
            'title',
            'report',
            'status',
            'latitudeCoordinate',
            'longitudeCoordinate',
            'solicitationCategory',
            'created_at',
            'updated_at',
        ];
    }

    public function test_should_create_solicitation_when_data_is_valid(): void
    {
        $solicitationCategory = SolicitationCategory::first();

        $data = [
            'title' => 'Solicitação de teste',
            'report' => 'Relato de teste',
            'latitudeCoordinate' => '-25.430',
            'longitudeCoordinate' => '-49.271',
            'solicitationCategoryId' => $solicitationCategory->id,
        ];

        $this->postJson($this->controllerAction('store'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getResponseStructure(),
            ]);

        $this->assertDatabaseHas(Solicitation::class, [
            'title' => $data['title'],
            'report' => $data['report'],
            'latitude_coordinate' => $data['latitudeCoordinate'],
            'longitude_coordinate' => $data['longitudeCoordinate'],
            'solicitation_category_id' => $data['solicitationCategoryId'],
        ]);
    }

    public function test_should_not_create_solicitation_when_data_is_invalid(): void
    {
        $data = [
            'title' => 'Solicitação de teste',
        ];

        $this->postJson($this->controllerAction('store'), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'report',
                'latitudeCoordinate',
                'longitudeCoordinate',
                'solicitationCategoryId',
            ]);

        $this->assertDatabaseMissing(Solicitation::class, [
            'title' => $data['title'],
        ]);
    }

    public function test_should_update_solicitation_when_data_is_valid(): void
    {
        $solicitation = Solicitation::factory()
            ->create();

        $solicitationCategory = SolicitationCategory::first();

        $data = [
            'title' => 'Solicitação de teste',
            'report' => 'Relato de teste',
            'status' => SolicitationStatusEnum::OPEN,
            'latitudeCoordinate' => '-25.430',
            'longitudeCoordinate' => '-49.271',
            'solicitationCategoryId' => $solicitationCategory->id,
        ];

        $this->putJson($this->controllerAction('update', $solicitation->id), $data)
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getResponseStructure(),
            ]);

        $this->refreshDatabase();

        $this->assertDatabaseHas(Solicitation::class, [
            'title' => $data['title'],
            'report' => $data['report'],
            'status' => $data['status'],
            'latitude_coordinate' => $data['latitudeCoordinate'],
            'longitude_coordinate' => $data['longitudeCoordinate'],
            'solicitation_category_id' => $data['solicitationCategoryId'],
        ]);
    }

    public function test_should_delete_solicitation_when_data_is_valid(): void
    {
        $solicitation = Solicitation::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $solicitation->id))
            ->assertNoContent();

        $this->refreshDatabase();

        $this->assertDatabaseMissing(Solicitation::class, [
            'id' => $solicitation->id,
        ]);
    }
}
