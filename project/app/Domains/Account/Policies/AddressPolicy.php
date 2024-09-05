<?php

namespace App\Domains\Account\Policies;

use App\Domains\Account\Models\User;

class AddressPolicy
{
    /**
     * Determine whether the user can view its current address.
     */
    public function view(User $user): bool
    {
        return $user->can('address view');
    }

    /**
     * Determine whether the user can update its current address.
     */
    public function update(User $user): bool
    {
        return $user->can('address update');
    }
}
