<?php

namespace Tests\Unit\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\LikeSolicitationAction;
use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Models\UserSolicitation;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class LikeSolicitationActionTest extends TestCaseUnit
{
    public function test_should_like_a_solicitation_and_increment_its_likes_count()
    {
        $solicitationMock = $this->partialMock(Solicitation::class, function (MockInterface $mock) {
            $mock->shouldAllowMockingProtectedMethods();
            $mock->shouldReceive('increment')
                ->once()
                ->with('likes_count');
        });
        $solicitationMock->id = 1;
        $solicitationMock->current_status = SolicitationStatusEnum::OPEN;

        $data = UserSolicitationData::from([
            'status' => $solicitationMock->current_status,
            'solicitationId' => $solicitationMock->id,
            'userId' => 1,
            'actionDescription' => SolicitationActionDescriptionEnum::LIKE,
        ]);

        $this->mock(CreateUserSolicitationAction::class, function ($mock) use ($data) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($data)
                ->andReturn(new UserSolicitation);
        });

        (new LikeSolicitationAction)->execute($data, $solicitationMock);
    }
}
