<?php

namespace App\Domains\Account\Models;

use Illuminate\Database\Eloquent\Model;

class AddressCity extends Model
{
    protected $fillable = [
        'name',
        'state_id',
    ];
}
