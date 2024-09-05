<?php

namespace Tests\Unit\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\CreateSolicitationAction;
use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Models\Solicitation;
use Tests\Cases\TestCaseUnit;

class CreateSolicitationActionTest extends TestCaseUnit
{
    public function test_should_create_solicitation()
    {
        $data = SolicitationData::from([
            'title' => 'title',
            'description' => 'description',
            'latitudeCoordinates' => 1,
            'longitudeCoordinates' => 2,
            'solicitationCategoryId' => 3,
        ]);

        $this->mock(Solicitation::class)
            ->expects('create')
            ->andReturns(new Solicitation);

        (new CreateSolicitationAction)->execute($data);
    }
}
