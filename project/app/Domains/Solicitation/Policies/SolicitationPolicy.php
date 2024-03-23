<?php

namespace App\Domains\Solicitation\Policies;

use App\Domains\Account\Models\User;
use App\Domains\Shared\Policies\BasePolicy;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;

class SolicitationPolicy extends BasePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('solicitations create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Solicitation $solicitation): bool
    {
        return $user->can('solicitations update')
            && $this->checkIfModelBelongsToUser($user, $solicitation);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Solicitation $solicitation): bool
    {
        return $user->can('solicitations delete')
            && $this->checkIfModelBelongsToUser($user, $solicitation)
            && $solicitation->status !== SolicitationStatusEnum::RESOLVED;
    }
}
