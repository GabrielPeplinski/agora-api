<?php

namespace Tests\Unit\Domains\Solicitation\Actions\UserSolicitation;

use App\Domains\Solicitation\Actions\UserSolicitation\CreateUserSolicitationAction;
use App\Domains\Solicitation\Dtos\UserSolicitationData;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Models\UserSolicitation;
use Tests\Cases\TestCaseUnit;

class CreateUserSolicitationActionTest extends TestCaseUnit
{
    public function test_should_create_user_solicitation()
    {
        $data = UserSolicitationData::from([
            'solicitationId' => 1,
            'userId' => 2,
            'status' => 'status',
            'actionDescription' => SolicitationActionDescriptionEnum::CREATED,
        ]);

        $this->mock(UserSolicitation::class)
            ->expects('create')
            ->andReturns(new UserSolicitation());

        (new CreateUserSolicitationAction())->execute($data);
    }
}
