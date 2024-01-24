<?php

namespace App\Domains\Account\Models;

use Illuminate\Database\Eloquent\Model;

class AddressState extends Model
{
    protected $fillable = [
        'name',
        'name_abbreviation',
    ];
}
