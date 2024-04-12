<?php

namespace App\Domains\Account\Actions\User;

use App\Domains\Account\Models\User;

class UpdateUserAddressAction
{
    public function execute(User $user, int $addressId): void
    {
        $user->update([
            'address_id' => $addressId,
        ]);
    }
}
