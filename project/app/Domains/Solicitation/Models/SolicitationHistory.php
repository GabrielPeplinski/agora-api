<?php

namespace App\Domains\Solicitation\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitationHistory extends Model
{
    protected $fillable = [
        'status',
        'action_description',
        'register_by_user_id',
        'solicitation_id',
    ];
}
