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
            'stateAbbreviation',
            'zipCode',
        ];
    }

    public function test_should_create_address_when_data_is_valid(): void
    {
        $data = [
            'neighborhood' => 'Centro',
            'cityName' => 'Guarapuava',
            'stateAbbreviation' => 'PR',
            'zipCode' => '12345678',
        ];

        $this->putJson($this->controllerAction('createOrUpdate'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getResponseStructure(),
            ]);

        $this->assertTrue(current_user()->address()->exists());

        $address = current_user()->address;

        $this->assertEquals($data['neighborhood'], $address->neighborhood);
        $this->assertEquals($data['cityName'], $address->city->name);
        $this->assertEquals('Paraná', $address->city->state->name);
        $this->assertEquals($data['stateAbbreviation'], $address->city->state->name_abbreviation);
        $this->assertEquals($data['zipCode'], $address->zip_code);
    }

    public function test_should_update_address_when_user_already_has_address_created(): void
    {
        $this->createClientUserAddress();

        $this->assertTrue(current_user()->address()->exists());

        $data = [
            'neighborhood' => 'Morro Alto',
            'cityName' => 'Guarapuava',
            'stateAbbreviation' => 'PR',
            'zipCode' => '12345678',
        ];

        $this->putJson($this->controllerAction('createOrUpdate'), $data)
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getResponseStructure(),
            ]);

        $this->assertTrue(current_user()->address()->exists());

        $address = current_user()->address;

        $this->assertEquals($data['neighborhood'], $address->neighborhood);
        $this->assertEquals($data['cityName'], $address->city->name);
        $this->assertEquals('Paraná', $address->city->state->name);
        $this->assertEquals($data['stateAbbreviation'], $address->city->state->name_abbreviation);
        $this->assertEquals($data['zipCode'], $address->zip_code);
    }

    public function test_should_not_create_address_when_data_is_invalid(): void
    {
        $data = [
            'neighborhood' => 'Vila Carli',
        ];

        $this->putJson($this->controllerAction('createOrUpdate'), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'cityName',
                'stateAbbreviation',
                'zipCode',
            ]);

        $this->assertFalse(current_user()->address()->exists());

        $this->assertDatabaseMissing('addresses', [
            'user_id' => current_user()->id,
            'neighborhood' => 'Vila Carli',
        ]);
    }

    public function test_should_not_create_address_when_using_not_valid_state_abbreviation(): void
    {
        $data = [
            'neighborhood' => 'Centro',
            'cityName' => 'Guarapuava',
            'stateAbbreviation' => 'TS',
            'zipCode' => '12345678',
        ];

        $this->putJson($this->controllerAction('createOrUpdate'), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors('stateAbbreviation');

        $this->assertFalse(current_user()->address()->exists());

        $this->assertDatabaseMissing('addresses', [
            'user_id' => current_user()->id,
            'neighborhood' => 'Vila Carli',
        ]);
    }
}
