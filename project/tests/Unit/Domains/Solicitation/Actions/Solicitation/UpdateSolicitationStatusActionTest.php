<?php

namespace Tests\Unit\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\UpdateSolicitationStatusAction;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateSolicitationStatusActionTest extends TestCaseUnit
{
    public function test_should_update_a_solicitation_status()
    {
        $solicitationMock = $this->partialMock(Solicitation::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->with([
                    'current_status' => SolicitationStatusEnum::RESOLVED,
                ]);
        });
        $solicitationMock->id = 1;
        $solicitationMock->current_status = SolicitationStatusEnum::IN_PROGRESS;

        $data = UserSolicitationData::from([
            'status' => SolicitationStatusEnum::RESOLVED,
            'solicitationId' => $solicitationMock->id,
            'userId' => 1,
            'actionDescription' => SolicitationActionDescriptionEnum::LIKE,
        ]);

        (new UpdateSolicitationStatusAction)->execute($data, $solicitationMock);
    }
}
