<?php

namespace Tests\Unit\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\UpdateSolicitationAction;
use App\Domains\Solicitation\Dtos\SolicitationData;
use App\Domains\Solicitation\Models\Solicitation;
use Tests\Cases\TestCaseUnit;

class UpdateSolicitationActionTest extends TestCaseUnit
{
    public function test_should_update_solicitation()
    {
        $data = SolicitationData::from([
            'title' => 'title',
            'description' => 'description',
            'latitudeCoordinates' => 1,
            'longitudeCoordinates' => 2,
            'solicitationCategoryId' => 3,
        ]);

        $solicitationMock = $this->partialMock(Solicitation::class, function ($mock) {
            $mock->expects('update')
                ->once()
                ->andReturnTrue();
        });

        (new UpdateSolicitationAction())->execute($data, $solicitationMock);
    }
}
