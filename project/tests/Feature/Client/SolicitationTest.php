<?php

namespace Tests\Feature\Client;

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
            'solicitation',
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
    }
}
