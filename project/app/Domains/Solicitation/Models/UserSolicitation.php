<?php

namespace App\Domains\Solicitation\Models;

use App\Domains\Account\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSolicitation extends Model
{
    protected $table = 'users_solicitations';

    protected $fillable = [
        'solicitation_id',
        'user_id',
        'status',
        'action_description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function solicitation(): BelongsTo
    {
        return $this->belongsTo(Solicitation::class);
    }
}
