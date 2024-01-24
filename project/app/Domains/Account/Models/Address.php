<?php

namespace App\Domains\Account\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'zip_code',
        'neighborhood',
        'city_id',
        'user_id',
    ];
}
