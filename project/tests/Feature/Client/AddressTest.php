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
            'neighborhood' => 'Test Neighborhood',
            'cityName' => 'Test City',
            'stateName' => 'Test State',
            'stateAbbreviation' => 'TS',
            'zipCode' => '12345678',
        ];

        $this->putJson($this->controllerAction('createOrUpdate'), $data)
            ->assertOk()
            ->assertJsonStructure($this->getResponseStructure());
    }
}
