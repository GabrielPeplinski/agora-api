<?php

namespace App\Domains\Account\Models;

use Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

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

    protected static function newFactory(): AddressFactory
    {
        return AddressFactory::new();
    }
}
