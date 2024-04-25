<?php

namespace Tests\Feature\Client\Solicitation;

use App\Http\Api\Controllers\Client\Solicitation\MySolicitationsController;
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
}
