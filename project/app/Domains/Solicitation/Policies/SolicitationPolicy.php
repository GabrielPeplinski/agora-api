<?php

namespace App\Domains\Solicitation\Policies;

use App\Domains\Account\Models\User;
use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use App\Domains\Solicitation\Models\Solicitation;

class SolicitationPolicy
{
    private function belongsToCurrentUser(User $user, Solicitation $solicitation): bool
    {
        return $solicitation->userSolicitations()
            ->where('action_description', SolicitationActionDescriptionEnum::CREATED)
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Determine whether the user can view any of its solicitations.
     */
    public function view(User $user): bool
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
        return $user->can('solicitations update') && $this->belongsToCurrentUser($user, $solicitation);
    }

    /**
     * Determine whether the user can delete any of its solicitations.
     */
    public function delete(User $user, Solicitation $solicitation): bool
    {
        return $user->can('solicitations delete') && $this->belongsToCurrentUser($user, $solicitation);
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
    public function addImages(User $user, Solicitation $solicitation): bool
    {
        return $user->can('solicitations add images');
    }

    /**
     * Determine whether the user can update the status of any solicitations.
     */
    public function updateStatus(User $user, Solicitation $solicitation): bool
    {
        return $user->can('solicitations update status') &&
            $solicitation->status !== SolicitationStatusEnum::RESOLVED;
    }
}
