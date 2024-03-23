<?php

namespace App\Domains\Shared\Policies;

use App\Domains\Account\Models\User;
use Illuminate\Database\Eloquent\Model;

class BasePolicy
{
   protected function checkIfModelBelongsToUser(User $user, Model $model): bool
   {
       return $user->id === $model->user_id;
   }
}
