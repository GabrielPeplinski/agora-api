<?php

namespace App\Domains\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'zip_code',
        'neighborhood',
        'city_id',
        'user_id',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(AddressCity::class);
    }
}
