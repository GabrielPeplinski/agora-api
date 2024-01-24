<?php

namespace App\Domains\Account\Models;

use Illuminate\Database\Eloquent\Model;

class AddressState extends Model
{
    protected $table = 'address_states';

    protected $fillable = [
        'name',
        'name_abbreviation',
    ];
}
