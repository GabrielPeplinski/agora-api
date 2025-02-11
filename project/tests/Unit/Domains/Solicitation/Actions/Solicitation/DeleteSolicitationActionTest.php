<?php

namespace Tests\Unit\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\DeleteSolicitationAction;
use App\Domains\Solicitation\Models\Solicitation;
use Tests\Cases\TestCaseUnit;

class DeleteSolicitationActionTest extends TestCaseUnit
{
    public function test_should_delete_a_solicitation()
    {
        $solicitationMock = $this->partialMock(Solicitation::class, function ($mock) {
            $mock->shouldReceive('delete')
                ->once()
                ->andReturn(true);
        });

        (new DeleteSolicitationAction)->execute($solicitationMock);
    }
}
