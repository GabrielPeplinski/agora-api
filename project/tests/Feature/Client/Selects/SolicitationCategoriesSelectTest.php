<?php

namespace Tests\Feature\Client\Selects;

use App\Domains\Solicitation\Models\SolicitationCategory;
use App\Http\Api\Controllers\Client\Selects\SolicitationCategoriesSelectController;
use Tests\Cases\TestCaseFeature;

class SolicitationCategoriesSelectTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsClient();
        $this->useActionsFromController(SolicitationCategoriesSelectController::class);
    }

    private function getSolicitationCategoriesSelectResource(): array
    {
        return [
            'id',
            'name',
            'description',
        ];
    }

    public function test_should_return_solicitation_categories_select(): void
    {
        $solicitationCategories = SolicitationCategory::factory()
            ->count(3)
            ->create();

        $this->getJson($this->controllerAction())
            ->assertOk()
            ->assertJsonCount($solicitationCategories->count(), 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getSolicitationCategoriesSelectResource()],
            ]);
    }
}
