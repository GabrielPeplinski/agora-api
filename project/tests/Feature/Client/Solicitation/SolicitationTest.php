<?php

namespace Tests\Feature\Client\Solicitation;

use App\Domains\Solicitation\Models\SolicitationCategory;
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
                'data' => [
                    'id',
                    'category',
                    'description',
                    'latitudeCoordinates',
                    'longitudeCoordinates',
                    'status',
                ],
            ]);
    }
}
