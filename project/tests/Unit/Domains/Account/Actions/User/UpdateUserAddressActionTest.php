<?php

namespace Tests\Unit\Domains\Account\Actions\User;

use App\Domains\Account\Actions\User\UpdateUserAddressAction;
use App\Domains\Account\Models\User;
use PHPUnit\Framework\TestCase;

class UpdateUserAddressActionTest extends TestCase
{
    public function test_should_update_user_address()
    {
        $userMock = $this->createMock(User::class);

        $userMock->expects($this->once())
            ->method('update')
            ->with($this->equalTo([
                'address_id' => 1,
            ]));

        (new UpdateUserAddressAction())->execute($userMock, 1);
    }
}
