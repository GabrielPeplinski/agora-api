<?php

namespace Tests\Feature\Client;

use App\Http\Api\Controllers\Client\AddressController;
use Tests\Cases\TestCaseFeature;

class AddressTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loginAsClient();
        $this->useActionsFromController(AddressController::class);
    }

    private function getResponseStructure(): array
    {
        return [
            'id',
            'neighborhood',
            'cityName',
            'stateName',
            'stateAbbreviation',
            'zipCode',
        ];
    }

    public function test_should_create_address(): void
    {
        $data = [
            'neighborhood' => 'Centro',
            'cityName' => 'Guarapuava',
            'stateName' => 'Paraná',
            'stateAbbreviation' => 'PR',
            'zipCode' => '12345678',
        ];

        $this->putJson($this->controllerAction('createOrUpdate'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getResponseStructure(),
            ]);
    }
}
