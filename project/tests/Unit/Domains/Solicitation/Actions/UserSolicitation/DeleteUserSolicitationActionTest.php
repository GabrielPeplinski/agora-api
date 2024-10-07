<?php

namespace Tests\Unit\Domains\Solicitation\Actions\UserSolicitation;

use App\Domains\Solicitation\Actions\UserSolicitation\DeleteUserSolicitationAction;
use App\Domains\Solicitation\Models\UserSolicitation;
use Tests\Cases\TestCaseUnit;

class DeleteUserSolicitationActionTest extends TestCaseUnit
{
    public function test_should_delete_a_user_solicitation()
    {
        $userSolicitationMock = $this->partialMock(UserSolicitation::class, function ($mock) {
            $mock->shouldReceive('delete')
                ->once()
                ->andReturn(true);
        });

        (new DeleteUserSolicitationAction)->execute($userSolicitationMock);
    }
}
