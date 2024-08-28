<?php

namespace App\Domains\Solicitation\Policies;

use App\Domains\Account\Models\User;
use App\Domains\Solicitation\Models\Solicitation;

class SolicitationPolicy
{
    /**
     * Determine whether the user can view any of its solicitations.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('solicitations view any');
    }

    /**
     * Determine whether the user can view any of its solicitations.
     */
    public function view(User $user, Solicitation $solicitation): bool
    {
        return $user->can('solicitations view');
    }

    /**
     * Determine whether the user can create a new solicitation.
     */
    public function create(User $user): bool
    {
        return $user->can('solicitations create');
    }

    /**
     * Determine whether the user can update any of its solicitations.
     */
    public function update(User $user, Solicitation $solicitation): bool
    {
        return $user->can('solicitations update');
    }

    /**
     * Determine whether the user can delete any of its solicitations.
     */
    public function delete(User $user, Solicitation $solicitation): bool
    {
        return $user->can('solicitations delete');
    }

    /**
     * Determine whether the user can like any solicitation.
     */
    public function like(User $user): bool
    {
        return $user->can('solicitations like');
    }

    /**
     * Determine whether the user can add images to a new solicitation.
     */
    public function addImages(User $user): bool
    {
        return $user->can('solicitations add images');
    }
}
