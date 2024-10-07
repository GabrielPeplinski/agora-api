<?php

namespace Tests\Unit\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\LikeSolicitationAction;
use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use Tests\Cases\TestCaseUnit;

class LikeSolicitationActionTest extends TestCaseUnit
{
    public function test_should_like_a_solicitation_and_increment_its_likes_count()
    {
        $solicitationMock = $this->createMock(Solicitation::class);
        $solicitationMock->id = 1;
        $solicitationMock->current_status = SolicitationStatusEnum::OPEN;

        $data = UserSolicitationData::from([
            'status' => $solicitationMock->current_status,
            'solicitationId' => $solicitationMock->id,
            'userId' => 1,
            'actionDescription' => SolicitationActionDescriptionEnum::LIKE,
        ]);

        $this->mock(CreateUserSolicitationAction::class, function ($mock) use ($data, $solicitationMock) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($data);
        });

        (new LikeSolicitationAction())->execute(
           $data, $solicitationMock
        );
    }
}
